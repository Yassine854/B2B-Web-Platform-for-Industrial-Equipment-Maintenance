
# B2B Web Platform for Industrial Equipment Maintenance

A web-based platform developed to manage the maintenance of industrial equipment, allowing businesses to efficiently track, manage, and maintain their assets.

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgments](#acknowledgments)
- [Deployed Version](#deployed-version)

## Introduction
This project was developed as part of an internship at **Envision**, a digital agency specializing in B2B solutions. The platform helps companies manage their industrial equipment maintenance by assigning equipment, tracking diagnostics, and overseeing interventions. It is designed to optimize the operational efficiency of maintenance teams, minimizing unplanned downtime and improving asset management.

![dashboard off](https://github.com/user-attachments/assets/af4ad2e2-50d5-4d4f-a91b-bba531a763e3)



## Features
- **Administrator functionalities**:
  - Manage users, industrial pumps, diagnostics, and interventions.
  - Assign equipment to companies.
  - Generate real-time statistics and receive notifications.
  
- **Client functionalities**:
  - Track equipment assignments and diagnostics.
  - Monitor maintenance schedules and interventions.
  - Receive notifications for necessary equipment changes.

- **Additional features**:
  - Responsive UI for multi-device compatibility.
  - Secure data handling with robust security measures.
  
## Technologies Used
- **Backend**: Laravel (PHP)
- **Frontend**: Vue.js
- **Programming Languages**: 
  - PHP for backend logic.
  - JavaScript for interactive frontend components.
  
- **Tools and Software**:
  - **IDE**: Visual Studio Code
  - **UML Diagrams**: StarUML for software architecture design.

## Installation

To set up the project locally:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/your-project-name.git
    ```

2. **Navigate to the project directory:**
    ```bash
    cd your-project-name
    ```

3. **Install dependencies:**
    For Laravel:
    ```bash
    composer install
    ```

    For Vue.js:
    ```bash
    npm install
    ```

4. **Set up environment variables:**
    Copy `.env.example` to `.env` and configure your database and environment settings.

5. **Run migrations to set up the database:**
    ```bash
    php artisan migrate
    ```

6. **Run the development server:**
    ```bash
    php artisan serve
    ```

    For Vue.js:
    ```bash
    npm run serve
    ```

## Usage

### Administrator
- Access the dashboard to manage users, equipment, diagnostics, and interventions.
- View real-time stats and receive alerts about equipment maintenance needs.

### Client
- View assigned equipment, track maintenance schedules, and get notifications.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments
Special thanks to **Mahdi Msaed** and the team at **Envision** for their guidance and support throughout the project.

## Deployed Version
The project is deployed and can be accessed here: [B2B Web Platform](https://gsiapp.com/).
