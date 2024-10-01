# Exchange Currency Buy/Sell API Project
> Postman Fork Link<br><br>
[![Fork in Postman](https://run.pstmn.io/button.svg)](https://web.postman.co/network/import?collection=27789161-61bbf365-546f-4e2f-a6b5-7e46a632599c-2s9YJdWi2J&referrer=https%3A%2F%2Fdocumenter.getpostman.com%2Fview%2F27789161%2F2s9YJdWi2J&versionTag=latest&source=documenter&traceId=undefined)

<br><br>

In this project, foreign exchange buying/selling transactions are calculated in return for certain commissions and the CBRT foreign exchange rates are listed.

Clone project to your local machine:

> Create a database named '*currency_bs*'

bash

git clone https://github.com/ArtinBaharoglu/currencybs.git


Copy the `.env.example` file to `.env`:

bash

cp .env.example .env


> Don't forget configure the database settings
> 
> In order to avoid problems with local SSL when reading the TCMB exchange rates, an arrangement has been made in the Teknomavi package Doviz.php file located in the vendor;
<br>
// Disable SSL checking,
<br>
$curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
<br>
$curl->setOption(CURLOPT_SSL_VERIFYHOST, false);


Install composer dependencies:

bash

composer install

bash 

composer update


Prepare project:

bash

php artisan key:generate


bash

php artisan key:migrate

bash

php artisan migrate

Run the project:

bash

php artisan serve

# currencybs
# currency-bs-api
