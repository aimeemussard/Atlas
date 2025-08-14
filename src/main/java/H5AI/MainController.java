package H5AI;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.HashMap;
import java.util.Map;
import java.util.Scanner;
import java.util.TimeZone;
import java.util.regex.Pattern;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;

import io.github.cdimascio.dotenv.Dotenv;
import jakarta.servlet.http.HttpServletRequest;

@Controller
public class MainController {

        public Map<String, Object> map = new HashMap<>();
        public static Map<String, Object> results = new HashMap<>();
        public static ArrayList<String> history = new ArrayList<>();
        public static String rootPath = Dotenv.load().get("ROOT");
        public String mainDir = rootPath.substring(rootPath.lastIndexOf('/'));
        public static int lastPointer = -1;
        public static int pointer = 0;
        public static String backPath = "";
        public static String forwardPath = "";
        public static String direction = "";

        @GetMapping({"/H5AI", "/H5AI/**"})
        public String index(HttpServletRequest request, Model model, @RequestParam(defaultValue = "visit") String action, @RequestParam(defaultValue = "") String sort, @RequestParam(defaultValue = "") String order) throws IOException {

                /*Resets maps*/
                map.clear();
                results.clear();

                /*Get full URI*/
                String fullURI = request.getRequestURI();
                String search = request.getParameter("search");

                /*Fill result map when user search a file by its name recursively from rootpath*/
                if(search != null){
                        searchFile(new File(rootPath), results, search);
                }

                /*keeps tracks of direction order*/
                direction = order;

                /*Add path to history when history is already filled with at least one value, prevents error if back is used to access previous page*/
                if(history.size() > 0) {
                        /*Default action no forward or back*/
                        if(action.equals("visit")){
                                /*Prevents adding new values when refresh */
                                if(!history.get(history.size()-1).equals(fullURI)){
                                        if(lastPointer +1 != pointer){
                                                        for(int i= pointer+1; i < history.size(); i++){
                                                                history.set(i,"erase");
                                                        }
                                                        history.removeIf( n -> n == "erase" );
                                        }
                                        pointer++;
                                        backPath = history.get(pointer-1);
                                        forwardPath = "";
                                        history.add(fullURI);
                                        lastPointer = pointer -1;
                                }
                        }
                        /*Forward action */
                        else if (action.equals("forward")){
                                pointer++;
                                if(pointer<history.size()-1){
                                        forwardPath = history.get(pointer+1);
                                }else{
                                        forwardPath = "";
                                }
                                backPath = history.get(pointer-1);
                        }
                        /*Back action */
                        else if (action.equals("back")){
                                pointer--;
                                if(pointer > 0){
                                        backPath = history.get(pointer-1);
                                }else{
                                        backPath = "";
                                }
                                forwardPath = history.get(pointer+1);
                        }
                }
                /*Add history when first visit*/
                else{
                        history.add(fullURI);
                        backPath = "";
                        forwardPath = "";
                }

                /*Removes H5AI from the relative path*/
                String relativePath = fullURI.substring(mainDir.length());
                
                if (relativePath.isEmpty()) {
                        relativePath = "";
                }

                /*Retrieve all subfolder and files from target folder*/
                File target = new File(rootPath + relativePath);
                
                readFolder(target, map);

                if(!sort.equals("") && !direction.equals("")){
                        map = sortFolder(map, sort, direction);
                }

                /*Retrieve tree structure for sidebar*/
                File root = new File(rootPath);
                Map<String, Object> fullTree = readFolderContent(root);

                // Retrieve all folders for search bar
                // ArrayList<String> allFolders = new ArrayList<>();
                // searchBar(target, relativePath, allFolders);

                /*Generate array of every paths for breadcrumb*/
                String regex = "[/]";
                String[] paths = fullURI.substring(1).split(regex);

                ArrayList<Object> breadcrumb = new ArrayList<>();
                for (String path : paths) {
                        /*For each path a new array is created containing the url of the target path*/
                        Map<String, Object> array = new HashMap<>();

                        String url = "";

                        for (String subPath : paths) {
                                url += subPath + '/';
                                if (subPath == path) {
                                        break;
                                }
                        }

                        array.put(path, url);
                        breadcrumb.add(array);
                }

                /*Create attributes to be used inside of templates*/
                model.addAttribute("map", map);
                model.addAttribute("fullTree", fullTree);
                model.addAttribute("breadcrumb", breadcrumb);
                //model.addAttribute("path", relativePath);
                model.addAttribute("backPath", backPath);
                model.addAttribute("forwardPath", forwardPath);
                model.addAttribute("history", history);
                model.addAttribute("lastPointer", lastPointer);
                model.addAttribute("pointer", pointer);
                model.addAttribute("fullPath", fullURI);
                model.addAttribute("direction", direction);
                model.addAttribute("results", results);


                return "index";
        }

        public Map<String, Object> sortFolder(Map<String, Object> array, String sortBy, String direction) {
                
                ArrayList<Map<String, Object>> files = (ArrayList<Map<String, Object>>) array.get("files");
                /*If there's no files index we return the array as it is */
                if (files == null) return array;

                /*Comparator interface defines how to compare two values of an array*/
                Comparator<Map<String, Object>> comparator = (file1, file2) -> {

                        Object value1 = file1.get(sortBy);
                        Object value2 = file2.get(sortBy);

                        /*Checks if the two values are of same type and return a negative number if 1 is less than 2, zero is equals, or a positive number if 1 is greater than 2 --> sorting by index*/
                        if (value1 instanceof Comparable && value2 instanceof Comparable) {
                                return ((Comparable) value1).compareTo(value2);
                        }
                        return 0;
                };

                /*Change direction of sorting : ascending or descending depending of direction value with the reversed method of the comparator Interface */
                if (direction.equals("desc")) {
                        comparator = comparator.reversed();
                }

                /*Sort files*/
                files.sort(comparator);
                return array;
        }

        public static void readFolder(File folder, Map<String, Object> currentLevel) throws IOException {
                if (folder.exists() && folder.isDirectory()) {
                        /*List every files and subdirectories inside target folder */
                        for (File fileEntry : folder.listFiles()) {

                                String absolutePath = fileEntry.getAbsolutePath();
                                String relativePath = absolutePath.replace(rootPath, "");

                                if (fileEntry.isDirectory()) {
                                        String dirName = fileEntry.getName();

                                        Map<String, Object> subMap = new HashMap<>();

                                        currentLevel.computeIfAbsent("folders", key -> new ArrayList<Map<String, String>>());

                                        Map<String, String> folderInfo = new HashMap<>();
                                        folderInfo.put("name", dirName);
                                        folderInfo.put("path", "/H5AI"+relativePath);
                                        ((ArrayList<Map<String, String>>) currentLevel.get("folders")).add(folderInfo);

                                } else {
                                        Map<String, Object> fileInfo = new HashMap<>();
                                        fileInfo.put("name", fileEntry.getName());
                                        fileInfo.put("size", fileEntry.length());
                                        fileInfo.put("type", Files.probeContentType(fileEntry.toPath()));

                                        long date = fileEntry.lastModified();
                                        DateFormat format = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
                                        format.setTimeZone(TimeZone.getTimeZone("Etc/UTC"));
                                        String formatted = format.format(date);
                                        fileInfo.put("last_updated", formatted + "\n");
                                        fileInfo.put("path", "/H5AI"+relativePath);

                                        currentLevel.computeIfAbsent("files", k -> new ArrayList<String>());
                                        ((ArrayList<Object>) currentLevel.get("files")).add(fileInfo);
                                }
                        }
                } else if (folder.exists() && folder.isFile()) {

                        Map<String, Object> fileInfo = new HashMap<>();
                        fileInfo.put("name", "Nom : " + folder.getName());
                        fileInfo.put("size", folder.length() + " octets\n");

                        StringBuilder content = new StringBuilder();
                        int countLines = 0;
                        int countWords = 0;

                        Scanner myReader = new Scanner(folder);
                        while (myReader.hasNextLine()) {
                                String line = myReader.nextLine();
                                content.append(line).append("\n");
                                countLines++;
                                countWords += line.split("\\s+").length;
                        }
                        myReader.close();
                        fileInfo.put("content", content.toString());
                        fileInfo.put("lines", countLines);
                        fileInfo.put("words", countWords);
                        fileInfo.put("type", Files.probeContentType(folder.toPath()));
                        DateFormat format = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
                        format.setTimeZone(TimeZone.getTimeZone("Etc/UTC"));
                        String formatted = format.format(folder.lastModified());
                        fileInfo.put("last_updated", formatted);
                        currentLevel.put("file", fileInfo);
                }
        }

        public static void searchFile(File folder, Map<String, Object> currentLevel, String search) throws IOException {
                if (folder.exists() && folder.isDirectory()) {
                        File[] entries = folder.listFiles();
                        if (entries != null) {
                                for (File fileEntry : entries) {
                                        String absolutePath = fileEntry.getAbsolutePath();
                                        String relativePath = absolutePath.replace(rootPath, "");

                                        if (fileEntry.isDirectory()) {
                                                
                                                String regex = Pattern.quote(search) + "[^/]*$";
                                                String dirName = fileEntry.getName();
                                                Map<String, Object> subMap = new HashMap<>();
                                                
                                                if (dirName.matches(regex)) {
                                                        results.computeIfAbsent("folders", key -> new ArrayList<Map<String, String>>());
                                                        Map<String, String> folderInfo = new HashMap<>();
                                                        folderInfo.put("name", dirName);
                                                        folderInfo.put("path", "/H5AI"+relativePath);
                                                        ((ArrayList<Map<String, String>>) results.get("folders")).add(folderInfo);
                                                }
                                                
                                                searchFile(fileEntry, subMap, search);
                                        } else {
                                                // Create info for a file
                                                Map<String, Object> fileInfo = new HashMap<>();
                                                fileInfo.put("name", fileEntry.getName());
                                                fileInfo.put("size", fileEntry.length());
                                                fileInfo.put("type", Files.probeContentType(fileEntry.toPath()));

                                                long date = fileEntry.lastModified();
                                                DateFormat format = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
                                                format.setTimeZone(TimeZone.getTimeZone("Etc/UTC"));
                                                String formatted = format.format(date);
                                                fileInfo.put("last_updated", formatted);
                                                fileInfo.put("path", "/H5AI"+relativePath);

                                                String regex = Pattern.quote(search) + "[^/]*\\..*$";
                                                if(fileEntry.getName().matches(regex)){
                                                        results.computeIfAbsent("files", key -> new ArrayList<Map<String, Object>>());
                                                        ((ArrayList<Map<String, Object>>) results.get("files")).add(fileInfo);
                                                }
                                        }
                                }
                        }
                }
        }            

        public static Map<String, Object> readFolderContent(File folder) throws IOException {
                Map<String, Object> tree = new HashMap<>();
                if (folder.exists() && folder.isDirectory()) {
                        File[] entries = folder.listFiles();
                        if (entries != null) {
                                for (File fileEntry : entries) {
                                        if (fileEntry.isDirectory()) {
                                                tree.put(fileEntry.getName(), readFolderContent(fileEntry));
                                        } else {
                                                tree.computeIfAbsent("files", key -> new ArrayList<String>());
                                                ((ArrayList<String>) tree.get("files")).add(fileEntry.getName());
                                        }
                                }
                                
                        }
                }
                return tree;
        }

        // public static void searchBar(File folder, String currentPath, ArrayList<String> folders) {
        //         if (folder.exists() && folder.isDirectory()) {
        //                 for (File fileEntry : folder.listFiles()) {
        //                         if (fileEntry.isDirectory()) {
        //                                 String fullPath = currentPath + "/" + fileEntry.getName();
        //                                 folders.add(fullPath);
        //                                 searchBar(fileEntry, fullPath, folders);
        //                         }
        //                 }
        //         }
        // }

        @GetMapping("/error")
        public String error(Model model) {
                model.addAttribute("content", "error :: error");
                return "layout/base";
        }
}
