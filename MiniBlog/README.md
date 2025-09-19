Project Structure Overview
public/
The entry point of the application where all web requests begin. This directory contains the front controller (index.php) and publicly accessible assets like CSS, JavaScript, and images.

src/
The brain of the application housing all business logic. This is where you'll find Controllers, Entities, Services, and other PHP classes that define your application's functionality.

templates/
The face of the application containing all Twig template files. These view files define the user interface and presentation layer that users interact with in their browsers.

config/
The rulebook of the application storing all configuration settings. This directory contains files for routing, services, packages, and other parameters that control how the application behaves.

Getting Started
Create a new project: symfony new mvc-demo --webapp

Navigate to the project: cd mvc-demo

Start the development server: symfony serve
