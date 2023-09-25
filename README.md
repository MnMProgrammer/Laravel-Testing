# Laravel-Testing
 
Filtering down to one test in a file
```
vendor/bin/phpunit --filter a_project_requires_a_title
````

Running entire test suite 
```
vendor/bin/phpunit tests/Feature/ProjectsTest/php
```

Refreshing migration (if new tables or columns added)
```
php artisan migrate:refresh
```

Creating an alias 
```
alias pf="vendor/bin/phpunit --filter"
pf a_project_requires_a_title
```

Creating a factory 
```
php artisan make:factory ProjectFactory --model="App\Models\Project"
```

May need to run cache clear to get correct results from test
```
php artisan config:clear
php artisan optimize
```