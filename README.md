
# Order collection system

## Description
This project leverages Laravel and Vue.js to develop an order collection system tailored to meet the requirements of Health Maintenance Organizations (HMOs). The system aims to streamline order management processes and provide HMOs with the necessary tools for efficient batch processing and monitoring.

## Key Features

### Flexible Batching Criteria/Batching Rules
- HMOs can define their preferred criteria for batching orders, such as by encounter date or date of order filing, catering to diverse operational requirements.

### Batch Identification
- Batches are uniquely identified using a combination of the provider's name and the month and year, ensuring robust and distinct batch identification to prevent conflicts or confusion.

### Automated Batch Processing
- Automated processes streamline batch processing for HMOs, with orders automatically assigned to the appropriate batch based on rules specified by each HMO, reducing manual intervention and improving efficiency.

### Reporting and Monitoring
- Comprehensive reporting and monitoring capabilities empower HMOs with insights into batch status, order counts, total amount, and other metrics, facilitating informed decision-making.

## Endpoint for Order Submission

The system provides an endpoint `api/v1/provider/submit-order` for submitting orders. HMOs can utilize this endpoint to submit new orders seamlessly, ensuring efficient order management within the system.


## Running the App
To run the App, you must have:
- **PHP** (https://www.php.net/downloads)
- **MySQL** (https://www.mysql.com/downloads/)
- **Phpunit**

Clone the repository to your local machine using the command
```console
$ git clone *remote repository url*
```

## Configure app
Create an `.env` and copy `.env.example` content into it using the command.

```console
$ cp .env.example .env
```


### Environment
Configure environment variables in `.env` for dev environment based on your MYSQL database configuration


```  
DB_CONNECTION=<YOUR_MYSQL_TYPE>
DB_HOST=<YOUR_MYSQL_HOST>
DB_PORT=<YOUR_MYSQL_PORT>
DB_DATABASE=<YOUR_DB_NAME>
DB_USERNAME=<YOUR_DB_USERNAME>
DB_PASSWORD=<YOUR_DB_PASSWORD>

```
Also, Ensure to set your mailclient configuration in the `.env`

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@minisend.com
MAIL_FROM_NAME="${APP_NAME}"

```

Lastly, Ensure to set your base api url configuration in the `.env` for frontend usage. There will be issues if this is not set correctly.
Depending on if you use valet or artisan serve, it can be http://fullstack-php-test.test/api/v1 or http://localhost:800/api/v1

```
MIX_API_URL=http://fullstack-php-test.test/api/v1
```


### LARAVEL INSTALLATION
Install the dependencies and start the server and run app setup command. 
Also Seeder was set up for Hmos. Hmos can be seeded into database  using
`php artisan db:seed` as stated below

```console
$ composer install (might need add --ignore-platform-reqs in case of compatitbity issues)
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve (if you don't use Valet)
```

### VUE INSTALLATION
Install the dependencies and start the server

```console
$ npm install && npm run dev
```


You should be able to visit your app at your laravel app base url e.g http://localhost:8000 or http://fullstack-php-test.test/ (Provided you use Laravel Valet).

### PHPUNIT
To run general test, use command
```console
$ composer test
```


### POSTMAN API DOCUMENTATION
The postman documentation for the API can be found- https://documenter.getpostman.com/view/9428869/2sA35Bc55h


## Programming Decisions, Assumptions, and Suggestions

### Different Batching Rules
- HMOs can have varying batching rules, represented as an enum column in the hmos table. In this project, batching rules are limited to encounter_month and month_filed, hence the decision to utilize enums. If the scope of rules expands in the future, they can be extended into their own table, establishing a relationship with the hmos table, for better organization and management.

### Simplicity in Notification
- To streamline notification processes, an email column was added to the hmo table, allowing direct communication with HMOs. Although effective for this project, a more comprehensive solution would involve a hmo_users table to manage HMO employees, ensuring notifications are directed based on individual roles within the organization.

### Order Batching Approach
- Orders are batched dynamically as they enter the system, rather than employing scheduled automated batching at the end of each month. This method ensures that batches for each month, for each provider, are readily available to the HMO throughout the month, facilitating timely access and processing.

### Decision Regarding Laravel Actions
- While I am familiar with the Laravel Actions framework, for this project, I opted to leverage a different approach that aligns closely with my expertise. Although Laravel Actions could offer advantages in certain scenarios, I chose to utilize a service-based approach, which I am equally comfortable with. This decision was made to effectively showcase my skills and capabilities while ensuring the project's success
