
Built by https://www.blackbox.ai

---

# SMTP Testing Tool

## Project Overview
The SMTP Testing Tool is a web-based application designed to facilitate the testing of SMTP server configurations. It allows users to enter server details and send test emails, making it a valuable resource for developers and system administrators needing to verify SMTP settings quickly and efficiently.

## Installation
To set up the SMTP Testing Tool on your local machine, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/smtp-testing-tool.git
   cd smtp-testing-tool
   ```

2. **Install Dependencies:**
   Ensure you have Composer installed to manage PHP dependencies. Use the following command to install PHPMailer:
   ```bash
   composer install
   ```

3. **Run a Local Server:**
   You can use the built-in PHP server for testing:
   ```bash
   php -S localhost:8000
   ```
   Open your browser and navigate to `http://localhost:8000` to access the application.

## Usage
1. Open the application in your web browser.
2. Fill in the SMTP Server Details including Host, Port, Encryption type, Username, and Password.
3. Enter the Sender and Recipient email addresses, Subject, and Message you want to send.
4. Click on the "Send Test Email" button to send the email.
5. The application will provide feedback on whether the email was sent successfully or if there was an error.

## Features
- User-friendly interface for entering SMTP details and email content.
- Supports various encryption methods (SSL and TLS).
- Displays success or error messages after sending the email.
- Responsive design that works well on both desktop and mobile devices.

## Dependencies
The application utilizes the following dependencies:
- **PHPMailer**: For sending emails via SMTP.

Ensure that you run the following command to install the required PHP dependencies:
```bash
composer install
```

## Project Structure
The project comprises the following files and directories:

```plaintext
smtp-testing-tool/
│
├── index.html           # Main interface for the SMTP Testing Tool.
├── send_email.php       # PHP script that handles the email sending.
├── about.html           # About Us page.
├── contact.html         # Contact Us page.
├── privacy.html         # Privacy Policy page.
├── vendor/              # Directory containing installed PHP dependencies.
└── composer.json        # Composer configuration and dependencies.
```

### Explanation of Key Files:
- **index.html**: The main HTML file where users can input SMTP details and send test emails.
- **send_email.php**: The backend script that processes the email send request utilizing PHPMailer.
- **about.html, contact.html, privacy.html**: Additional pages providing information regarding the tool and its usage.

## Contributing
Contributions to the SMTP Testing Tool are welcome! If you have suggestions for improvements or find a bug, please open an issue or submit a pull request. 

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.