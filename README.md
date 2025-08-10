<div style="text-align:center" align="center">
<img src="./public/assets/images/Aura_Thumbnail.png" alt="Aura Logo" style="border-radius:10px" />
</div>

## 1. Introduction

The **<span style="color:#007bff">Aura</span>** Platform is an <span style="color:#007bff">**AI-powered Laravel-based API**</span> application designed using the **<span style="color:#007bff">MVC architecture</span>** that allows students to upload PDF documents and receive intelligent AI-generated summaries. The platform leverages advanced AI technology to extract key insights from academic documents, making studying more efficient and effective for students worldwide.

## 2. Used Technologies

### Back-End:

-   PHP 8.3+
-   Laravel 12.x
-   MySQL Database
-   RESTful API Architecture
-   Laravel Sanctum (API Authentication)
-   Queue System for Background Processing
-   Mail Services (SMTP/Email Notifications)

### Additional Libraries:

-   PDF Parser/Reader
-   File Storage (Local/Cloud)
-   Event Broadcasting
-   Cache Management
-   API Rate Limiting

## 3. Prerequisites

Before running the application, ensure you have the following installed:

-   PHP 8.3 or higher
-   PHP package manager (Composer)
-   Laravel 12.x
-   MySQL Database
-   Web server (Apache, Nginx, or similar)
-   AI API Keys (OpenAI or Claude)

OR

-   All in one solutions (ex: XAMPP, Laragon, Laravel Herd)

    -   Recommended: Install **<span style="color:#007bff">Laragon</span>**

        > For a smooth and hassle-free local development setup, we recommend installing **<span style="color:#007bff">Laragon</span>**. It's a powerful all-in-one environment that comes preconfigured with essential tools like PHP, MySQL, Composer, and more. **<span style="color:#007bff">Laragon</span>** is lightweight, easy to use, and ideal for running Laravel API projects like **<span style="color:#007bff">Aura</span>**.

        -   [Download Laragon](https://laragon.org/download/)

## 4. Installation and Setup

To set up the project, follow these steps:

1- Clone the repository:

```bash
git clone https://github.com/Ammoor/Aura.git
cd Aura
```

2- Install dependencies:

```bash
composer install
```

3- Create and configure the **<span style="color:#007bff">.env</span>** file:

```bash
cp .env.example .env
php artisan key:generate
```

Make sure you set the **<span style="color:#007bff">.env</span>** file with proper configuration including:

-   Database credentials
-   AI API keys
-   Mail configuration
-   File storage settings

4- Run migrations:

```bash
php artisan migrate
```

5- Create storage link for file uploads:

```bash
php artisan storage:link
```

6- Start the queue worker (for background processing):

```bash
php artisan queue:work
```

7- Start the development server:

```bash
php artisan serve
```

## 5. Configuration

The **<span style="color:#007bff">.env</span>** file should be configured with the following:

-   **APP_URL:** The URL where your API will be hosted
-   **Database configuration:** DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
-   **AI API Configuration:** OPENAI_API_KEY or CLAUDE_API_KEY
-   **Mail Configuration:** MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD
-   **File Storage:** FILESYSTEM_DISK (local, s3, etc.)

## 6. API Authentication

The API uses **<span style="color:#007bff">Laravel Sanctum</span>** for token-based authentication:

### User Registration & Verification:

-   **Email Verification:** Users must verify their email before accessing AI features
-   **Secure Registration:** Password hashing and validation
-   **Token Generation:** API tokens for authenticated requests

### Authentication Flow:

1. User registers with email and password
2. Email verification code is sent
3. User verifies email with code
4. API token is generated for authenticated requests
5. Token must be included in Authorization header for protected endpoints

## 7. Features

### Core Features:

-   **PDF Upload & Processing:**

    -   Secure file upload with validation
    -   PDF text extraction and parsing
    -   File storage management

-   **AI-Powered Summarization:**

    -   Integration with advanced AI models
    -   Intelligent content analysis
    -   Customizable summary length and style

-   **User Management:**
    -   Secure user registration and authentication
    -   Email verification system
    -   Profile management

### API Endpoints:

#### Authentication:

-   `POST /api/register` - User registration
-   `POST /api/verify-email` - Email verification
-   `POST /api/login` - User login
-   `POST /api/logout` - User logout

#### PDF Processing:

-   `POST /api/upload-pdf` - Upload PDF for summarization
-   `GET /api/summaries` - Get user's summary history
-   `GET /api/summaries/{id}` - Get specific summary
-   `DELETE /api/summaries/{id}` - Delete summary

#### User Profile:

-   `GET /api/user` - Get user profile
-   `PUT /api/user` - Update user profile
-   `DELETE /api/user` - Delete user account

### Email Notifications:

**<span style="color:#007bff">Aura</span>** features a comprehensive email notification system:

-   **Welcome Email:** Sent after successful email verification
-   **Verification Email:** Contains verification code for account activation
-   **Login Notification:** Security alert for new login sessions
-   **Account Deletion:** Confirmation email when account is deleted
-   **Summary Ready:** Notification when PDF summarization is complete

All emails are professionally designed with consistent branding and responsive templates.

## 8. Database Schema

The application uses the following main tables:

-   **Users Table:** Stores user authentication and profile information
-   **Pending Email Verifications Table:** Manages email verification codes
-   **PDF Summaries Table:** Stores processed PDF summaries and metadata
-   **User Sessions Table:** Tracks user login sessions for security

## 9. AI Integration

**<span style="color:#007bff">Aura</span>** leverages cutting-edge AI technology to provide intelligent PDF summarization:

### Supported AI Models:

-   **OpenAI GPT Models:** Advanced language understanding and summarization
-   **Claude AI:** High-quality content analysis and summary generation

### AI Processing Features:

-   **Intelligent Content Extraction:** Advanced PDF parsing and text extraction
-   **Context-Aware Summarization:** AI understands document structure and importance
-   **Customizable Output:** Different summary styles and lengths available
-   **Quality Assurance:** AI-powered content validation and quality checks

## 10. Security Features

### Data Protection:

-   **Secure File Upload:** File validation and sanitization
-   **Encrypted Storage:** Sensitive data encryption
-   **Rate Limiting:** API rate limiting to prevent abuse
-   **Input Validation:** Comprehensive request validation

### Authentication Security:

-   **Password Hashing:** Secure password storage using Laravel's built-in hashing
-   **Token Management:** Secure API token generation and management
-   **Email Verification:** Required email verification for account activation
-   **Session Security:** Secure session management and tracking

## 11. Performance & Scalability

### Background Processing:

-   **Queue System:** Heavy operations processed in background
-   **Asynchronous Processing:** Non-blocking PDF processing
-   **Email Queuing:** Email notifications sent asynchronously

### Optimization:

-   **Caching:** Intelligent caching for improved performance
-   **Database Optimization:** Efficient queries and indexing
-   **File Management:** Optimized file storage and retrieval

## 12. API Documentation

### Base URL:

```
https://your-domain.com/api
```

### Authentication:

All protected endpoints require an Authorization header:

```
Authorization: Bearer {your-api-token}
```

### Response Format:

All API responses follow a consistent format:

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data
    },
    "statusCode": 200
}
```

### Error Handling:

Comprehensive error responses with detailed messages and appropriate HTTP status codes.

## 13. Development & Testing

### Testing:

-   Unit tests for core functionality
-   Feature tests for API endpoints
-   Integration tests for AI services

### Development Tools:

-   **Laravel Telescope:** Application debugging and monitoring
-   **Laravel Tinker:** Interactive development environment
-   **API Testing:** Postman collections available

## 14. Deployment

### Production Requirements:

-   PHP 8.3+ with required extensions
-   MySQL 8.0+ or compatible database
-   Web server (Nginx/Apache) with proper configuration
-   SSL certificate for HTTPS
-   AI API keys and proper rate limits

### Environment Setup:

-   Configure `.env` for production
-   Set up queue workers
-   Configure file storage (local or cloud)
-   Set up monitoring and logging

## 15. Future Enhancements

### Planned Features:

-   **Multi-format Support:** Support for DOCX, TXT, and other document formats
-   **Advanced AI Options:** Multiple AI models and customization options
-   **Collaboration Features:** Shared summaries and team workspaces
-   **Analytics Dashboard:** Usage analytics and insights
-   **Mobile App Integration:** Dedicated mobile applications

### AI Improvements:

-   **Custom AI Training:** Domain-specific model fine-tuning
-   **Multi-language Support:** International language processing
-   **Advanced Summarization:** Chapter-wise and section-specific summaries

## 16. Contributing

We welcome contributions to **<span style="color:#007bff">Aura</span>**! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes with proper tests
4. Submit a pull request with detailed description

### Code Standards:

-   Follow PSR-12 coding standards
-   Write comprehensive tests
-   Document new features
-   Maintain backward compatibility

## 17. Support & Community

### Getting Help:

-   **Documentation:** Comprehensive API documentation
-   **Issue Tracker:** GitHub issues for bugs and feature requests
-   **Community:** Discord/Slack community for discussions

### Bug Reports:

If you encounter any issues, please report them through our GitHub repository with:

-   Detailed description of the problem
-   Steps to reproduce
-   Expected vs actual behavior
-   Environment details

## 18. License & Legal

### Open Source License:

**<span style="color:#007bff">Aura</span>** is released under the MIT License, allowing for both personal and commercial use with proper attribution.

### AI Usage Policy:

-   Responsible AI usage in compliance with provider terms
-   Data privacy and security compliance
-   Ethical AI practices and transparency

### Data Privacy:

-   **GDPR Compliant:** European data protection compliance
-   **Data Minimization:** Only necessary data collection
-   **User Rights:** Complete data control and deletion rights

## 19. Acknowledgments

**<span style="color:#007bff">Aura</span>** was built with the following technologies and services:

-   **Laravel Framework:** Robust PHP framework for rapid development
-   **AI Providers:** OpenAI and Anthropic for advanced AI capabilities
-   **Open Source Community:** Various packages and libraries that make this possible

## 20. Copyrights

This project was proudly created by the **<span style="color:#007bff">Aura</span>** development team, combining innovation, artificial intelligence, and educational technology. Users are welcome to use and customize the code under the MIT license, but we kindly request proper attribution to honor the team's efforts and the open-source community.

**<span style="color:#007bff">Aura</span>** - Empowering students with AI-powered learning tools.

&#169; 2025 **<span style="color:#007bff">Aura</span>**. All rights reserved.
