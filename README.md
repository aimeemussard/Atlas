# 🗺️ Atlas

Atlas est une application Java développée à l'aide de [**Spring Boot**](https://spring.io/projects/spring-boot) pour le back-end, [**Thymeleaf**](https://www.thymeleaf.org/) comme moteur de templates, et [**Tailwind CSS**](https://tailwindcss.com/) pour le front-end. Elle offre un système moderne et réactif d’indexation et de navigation de fichiers, avec tri, recherche et aperçu, pensé pour allier performance et élégance.

---

## ⚙️ Pré-requis

Il est recommandé d'avoir installé Node.js et Java au préalable, si ce n'est pas déjà fait vous pouvez:

- Installer [Java](https://www.java.com/fr/download/manual.jsp) sur MacOs/Windows, version recommandée : 24.0.1+

- Installer Java sur Ubuntu:

```bash
sudo apt install default-jre
```

- Installer [Node.js](https://nodejs.org/fr), version recommandée : 10.9.2


## 🛠️ Technologies utilisées

- **Java 24+**
- **Spring Boot**
- **Thymeleaf (Moteur de templates)**
- **Tailwind CSS**
- **Node.js / npm**

---

## 🚀 Installation

### 1. Cloner le dépôt :

```bash
git clone https://github.com/aimeemussard/Atlas
cd Atlas
```

### 2. Installer les dépendances : 

```bash
npm install
```

---

## 🎮 Utilisation

Une fois le dépôt cloné et toutes les dépendances installées, vous devez créer un fichier .env :

```bash 
        ROOT="absolute/path/to/H5AI/folder"
```

Ensuite vous pouvez lancer le server :

```bash
mvn spring-boot:run
```

Le site sera accessible à cette [adresse]('http://localhost:8080/H5AI').

N'oubliez pas de lancer TailwindCSS en parallèle:

```bash
npx tailwindcss -i ./src/main/resources/static/css/tailwind.css -o ./src/main/resources/static/css/output.css --watch
```

---

## 💻 Bon développement !

N'hésitez pas à nous contacter si vous avez des questions ou des retours.
