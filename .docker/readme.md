


How To Run Code Coverage Report Locally
1. Copy and rename .env.local.sample into .env
2. Build and run the containers with the app 
    
       ./whiparound.sh wa:up --build
       
3. Install PHP dependencies

       ./whiparound.sh wa:composer install       
    
4. Generate coverage report in `XML` format

       docker exec application-fpm vendor/bin/phpunit --testsuite=Micro --coverage-xml ./coverage-xml
       
5. Generate coverage report in `HTML` format
        
       docker exec application-fpm vendor/bin/phpunit --testsuite=Micro --coverage-html ./coverage

6. Open `coverage.xml` and `coverage/index.hml` to see the coverage report
