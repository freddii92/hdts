# HDTS
Our program is mainly divided into folders using the Model-View-Controller design pattern. Please see below for a list of folders and a description of each:
  - **Components** - Includes css, jpg, and php files for the navbar and style sheets.
  - **Controllers** - Files include functions for most classes that interact with the database via SQL queries.
  - **Core** - Config files to connect to the SQL database.
  - **Models** - Files that manage the data of the application.
  - **Old Files** - As the application evolves, old files are stored here to keep track of old versions.
  - **Pages** - The view part of the application. Stores files that implement the GUI side of our application.

## Necessary platform/installation instructions
Our program is built on using a SQL database and SQL queries hence a SQL database needs to be created. Once the database has been created, the mysqli-config.php needs to be updated as follows:
  - **$host** - Enter the DB server location.
  - **$db** - Enter your database.
  - **$username** - Enter your username.
  - **$password** - Enter the password. This is not ideal but it was necessary for the ease of the team project.
