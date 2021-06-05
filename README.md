
## About Service

Simple service for calculation Tribonacci numbers.
Service based on matrix exponentiation for reducing calculation cost from O(n) to O(log(n)) .
based on log(n) cost to calculate power of matrix 


Setup service: 
to run service you have to install docker-compose on your comp
firstly adapt your env in docker-compose.override.yml and .env

now build and run containers (php and nginx)
  - docker-compose up -d --build --remove-orphans

then install vendors:
    
- log in to container php: 
    - docker-compose exec --user=docker php bash
    
- run from container
    - composer install

Running service 

now from your browser  

- request:  
  http://$yourserverdomain/api/math-sequence/tribonacci?n=1000
    
- response:
  "815507705949063215012634973737520390101047421640059634182536354954214345249517992411833219017896606412691713984091121798255747368520490502996057925004321483423983646944214344896256767238653269823324951340326550513652712428004750634815007544492510783789625725711384"
