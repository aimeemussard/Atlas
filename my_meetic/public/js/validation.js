window.onload = ()=>{
        date_picker();
        // let cityInput = document.getElementById('city');
        // cityInput.addEventListener('change', (e)=>{
        //         let url = 'https://geo.api.gouv.fr/communes?nom='+e.target.value+'&fields=departement&boost=population&limit=5';
        //         let response = fetch(url);
        //         let json = response.json();
        //         console.log(json);
        // });
}

function validateRegister() {

        //gender
        let gender = false;
        let genderInput = document.getElementsByName('gender');
        console.log(genderInput);
        
        for (let i = 0; i < genderInput.length; i++) {
                if(genderInput[i].value.checked){
                        console.log('true');
                        gender = true;
                }
        }
        if(gender == false){
                alert("Veuillez renseigner votre genre.");
        }
        
        //name
        let firstname = false;
        let firstnameInput = document.getElementsByName('firstname')[0];
        let lastname = false;
        let lastnameInput = document.getElementsByName('lastname')[0];
        let namecheck = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u;

        //firstname
        if (firstnameInput.value.length == 0) {
                alert("Veuillez renseigner votre prénom.");
        } else if (firstnameInput.value.match(namecheck) && firstnameInput.value.length >= 2) {
                firstname = true;
        } else {
                alert("Veuillez renseigner votre prénom.");
                //document.getElementById("nom").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }

        //lastname
        if (lastnameInput.value.length == 0) {
                alert("Veuillez renseigner votre nom.");
        } else if (lastnameInput.value.match(namecheck) && lastnameInput.value.length >= 2) {
                lastname = true;
        } else {
                alert("Veuillez renseigner votre nom.");
                //document.getElementById("lastname").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }
        
        //email
        let email = false;
        let emailInput = document.getElementsByName("email")[0];
        let mailcheck = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (emailInput.value.length == 0) {
                alert("Veuillez renseigner une adresse e-mail");
        } else if (document.getElementById("email").value.match(mailcheck)) {
                email = true;
        } else {
                alert("Veuillez renseigner une adresse e-mail valide");
                //document.getElementById("email").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }
        
        //password
        let password = false;
        let passwordInput = document.getElementsByName("password")[0];
        let passcheck = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/;

        password = false;
        if (passwordInput.value.length == 0) {
                alert("Veuillez renseigner un mot de passe valide.");
        } else if (document.getElementById("password").value.match(passcheck)) {
                password = true;
        } else {
                alert("Votre mot de passe doit comporter entre 8 et 30 caractères et contenir une majuscule, un symbole et un chiffre.");
                //document.getElementById("email").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }

        //city
        let city = false;
        let cityInput = document.getElementsByName("city")[0];
        let citycheck = /^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;

        if (cityInput.value.length == 0) {
                alert("Veuillez renseigner une ville valide.");
        } else if (cityInput.value.match(citycheck)) {
                city = true;
        } else {
                alert("Veuillez renseigner une ville valide.");
                //document.getElementById("lastname").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }
        
        //hobby
        let hobby = false;
        let hobbyInput = document.getElementsByName('hobby');

        for (let i = 0; i < hobbyInput.length; i++) {
                if (hobbyInput[i].checked) {
                        hobby = true;
                }
        }
        if(hobby == false){
                alert("Veuillez renseigner au moins loisir.");
        }

        //birthdate
        let day;
        let month;
        let year;

        let selectDay = document.getElementById("day");
        let selectMonth = document.getElementById("month");
        let selectYear = document.getElementById("year");
        let selectedValueDay = selectDay.options[selectDay.selectedIndex].value;
        let selectedValueMonth = selectMonth.options[selectMonth.selectedIndex].value;
        let selectedValueYear = selectYear.options[selectYear.selectedIndex].value;

        const date = new Date();
        const actualYear = date.getFullYear();
        const actualMonth = (date.getMonth())+1;
        const actualDay = date.getDate();

        day = false;
        month = false;
        year = false;

        if (selectedValueDay === "0" && selectedValueMonth === "0" && selectedValueYear === "0" ) {
                alert("Veuillez renseigner votre date de naissance.");
        } else{
                if(parseInt(selectedValueYear) == (actualYear - 18) && parseInt(selectedValueMonth) == actualMonth && parseInt(selectedValueDay) < actualDay && selectedValueDay != "0" && selectedValueMonth != "0" && selectedValueYear != "0"){
                        year = true;
                        month = true;
                        day = true;
                }
                if(parseInt(selectedValueYear) == (actualYear - 18) && parseInt(selectedValueMonth) == actualMonth && parseInt(selectedValueDay) >= actualDay && selectedValueDay != "0" && selectedValueMonth != "0" && selectedValueYear != "0"){
                        alert("Vous n'avez pas 18 ans!");
                }
                if(parseInt(selectedValueYear) == (actualYear - 18) && parseInt(selectedValueMonth) < actualMonth && selectedValueDay != "0" && selectedValueMonth != "0" && selectedValueYear != "0"){
                        year = true;
                        month = true;
                        day = true;
                }
                if(parseInt(selectedValueYear) == (actualYear - 18) && parseInt(selectedValueMonth) > actualMonth && selectedValueDay != "0" && selectedValueMonth != "0" && selectedValueYear != "0"){
                        alert("Vous n'avez pas 18 ans!");
                }
                if(parseInt(selectedValueYear) < (actualYear - 18) && selectedValueDay != "0" && selectedValueMonth != "0" && selectedValueYear != "0"){
                        year = true;
                        month = true;
                        day = true;
                }
                if(selectedValueDay === "0"){
                        alert("Veuillez renseigner votre jour de naissance.");
                }
                if (selectedValueMonth === "0"){
                        alert("Veuillez renseigner votre mois de naissance.");
                }
                if (selectedValueYear === "0"){
                        alert("Veuillez renseigner votre année de naissance.");
                }
        }

        //submitCheck
        if (gender === true && firstname === true && lastname === true && day === true && month === true && year === true && email === true && password === true) {
                alert("Vous avez bien envoyé votre formulaire.");
                return true;
        } else {
                return false;
        }
}

function validateLogin() {

        //email
        let emailInput = document.getElementsByName("email")[0];
        let email = false;
        let mailcheck = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        
        if (emailInput.value.length == 0) {
                alert("Veuillez entrer une adresse e-mail");
        } else if (emailInput.value.match(mailcheck)) {
                email = true;
        } else {
                alert("Veuillez entrer une adresse e-mail valide");
                //document.getElementById("email").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }

        //password
        let passwordInput = document.getElementsByName("password")[0];
        let password = false;
        let passcheck = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/;

        if (passwordInput.value.length == 0) {
                alert("Veuillez entrer un mot de passe valide");
        } else if (passwordInput.value.match(passcheck)) {
                password = true;
        } else {
                alert("Votre mot de passe doit comporter entre 8 et 30 caractères et contenir une majuscule, un symbole et un chiffre");
            //document.getElementById("email").style.backgroundColor = 'rgb(' + 255 + ',' + 75 + ',' + 113 + ')';
        }

        //submitCheck
        if (email === true && password === true) {
                return true;
        } else {
                return false;
        }
}

function date_picker(){
                
        let div = document.getElementsByClassName('date_picker')[0];
        let today = new Date();
        let dayInput = document.createElement('select');
        dayInput.setAttribute('name', 'day');
        let monthInput = document.createElement('select');
        monthInput.setAttribute('name', 'month');
        let yearInput = document.createElement('select');
        yearInput.setAttribute('name', 'year');
        
        let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        for (let m = 0; m <= 11; m++) {
                let option = document.createElement('option');
                option.setAttribute('value', m.toLocaleString('en-US', {minimumIntegerDigits: 2}));
                if(m == today.getMonth()){
                        option.setAttribute('selected', '');
                }
                option.innerHTML = months[m];
                monthInput.appendChild(option);
        }
        div.appendChild(monthInput);

        generateDays(today.getMonth(), today.getFullYear(), false);

        for (let y = today.getFullYear()-90; y <= today.getFullYear()-18; y++) {
                let option = document.createElement('option');
                option.setAttribute('value', y);
                if(y == today.getFullYear()-18){
                        option.setAttribute('selected', '');
                }
                option.innerHTML = y;
                yearInput.appendChild(option);
        }
        div.appendChild(yearInput);
        
        monthInput.addEventListener('input', ()=>{
                generateDays(monthInput.value, yearInput.value, true, dayInput.value,);
        })
        yearInput.addEventListener('input', ()=>{
                generateDays(monthInput.value, yearInput.value, true, dayInput.value);
        })
        
        function generateDays(month, year, def, day = null){
                let nDays;
                dayInput.innerHTML = '';
                if (month != 1) {
                        if(month == 0 || month == 2 || month== 4 || month == 6 || month == 7 || month == 9 || month == 11){
                                nDays = 31;
                        }else{
                                nDays = 30;
                        }
                }else{
                        if(year%4 == 0 && year%100 != 0 ){
                                nDays= 29;
                        }else if(year%100 == 0 && year%400 == 0){
                                nDays= 29;
                        }else {
                                nDays = 28;
                        }
                }

                for (let d = 1; d <= nDays; d++) {
                        let option = document.createElement('option');
                        option.setAttribute('value', d.toLocaleString('en-US', {minimumIntegerDigits: 2}));
                        if((d == today.getDate() && def == false) || d == day){
                                option.setAttribute('selected', 'true');
                        }
                        option.innerHTML = d.toLocaleString('en-US', {minimumIntegerDigits: 2});
                        dayInput.appendChild(option);
                }
                div.insertBefore(dayInput, monthInput);
        }
}