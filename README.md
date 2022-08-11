# symfony-testing-with-a-bite


For run testing of all unit test:

 //////para instalar los tests unitarios
 symfony composer req phpunit --dev

 //////para correr tests unitarios

 symfony php bin/phpunit

 /////// para generer un test unitario
 symfony console make:test TestCase SpamCheckerTest

 /// para correr los test unitarios
 symfony php bin/phpunit
 symfony php bin/phpunit tests/Controller/ConferenceControllerTest.php


//// otra forma de correr un test unitario
symfony php bin/phpunit --filter testItDoesNotAllowToAddDinosaursToUnsecureEnclosures


//para listar todas los comandos de testings

./vendor/bin/phpunit -h
por ejemplo para correr el test para el primer elemento de un data provider fijado en un testing

symfony php bin/phpunit --filter 'testItDoesNotAllowToAddDinosaursToUnsecureEnclosures #1'
symfony php bin/phpunit --filter 'testItDoesNotAllowToAddDinosaursToUnsecureEnclosures @default response'

symfony php bin/phpunit --stop-on-failure --stop-on-error


## Annotations
- Mocking allows for us to test classes in complete isolation.
- When you test complext queries ant a real connection to database, you need an integration test.

//para correr pruebas de integracion,crear base de datos de testings
1)completar el .env.test con la database uri
2)symfony console d:d:c --env=test
3)symfony console d:s:c --env=test
4)symfony console d:s:u --force --env=test


## Partial mocking
unit test + intragration test
Author @wolverine92 Aranda, Pablo Damian