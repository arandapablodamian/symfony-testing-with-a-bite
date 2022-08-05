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

Author @wolverine92 Aranda, Pablo Damian