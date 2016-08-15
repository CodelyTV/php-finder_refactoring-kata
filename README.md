# Introduction 

Here is the bad news: the new developer you hired has written some terrible, atrocious code. 
No one can understand what it does. 

The good news: at least there are unit tests to prove the code is working. 

You job is to refactor the code and make it readable, while keeping the code in working order (pass all tests). 

# How To Start

1. Clone this repository `git clone https://github.com/CodelyTV/incomprehensible-finder-refactoring-kata`
2. Install all the dependencies using Composer `composer install`
3. Run the tests with `vendor/bin/phpunit`. You also have available the `composer test` command which makes a previous lint process.
4. Start refactoring! 

The primary goal is to refactor the code in `src/Algorithm/Finder.php` - as it stands the code is incomprehensible. 

# Tips

* Start with simple rename refactors so you can better understand the abstractions you are working with. Rename any class or any variable. 
* Move on to extract methods and making the code more modular.
* See if you can also eliminate switch statements and multiple exit points from methods. 

Anything is fair game, create new classes, new methods, and rename tests. 
The only restriction is that the existing tests have to keep working. 
Lean on the tests and run them after every small change to make sure you are on the right path.

# How to End

You can stop when you feel the code is good enough, something you can come back to in 6 months and understand. 

# Helpful resources

## PHP 7

I've decided to port the kata directly to PHP 7 instead of 5.6. This will allow you to practice also with the new PHP features. By the way, if you're not used to it yet, here you have some useful resources:

* [PHP 7 new features](http://php.net/manual/en/migration70.new-features.php)
* [Scalar type declarations example](https://github.com/tpunt/PHP7-Reference#scalar-type-declarations)
* [Return type declarations example](https://github.com/tpunt/PHP7-Reference#return-type-declarations)

## PHPUnit 5.5

* [Introduction to writing tests for PHPUnit](https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)
* [Testing exceptions with PHPUnit](https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.exceptions)
* [PHPUnit assertions](https://phpunit.de/manual/current/en/appendixes.assertions.html)

## Refactoring

* [Refactoring.guru Code Smells catalog](https://refactoring.guru/smells/smells)
* [Refactoring.guru Refactorings catalog](https://refactoring.guru/catalog)
* [SourceMaking Refactorings catalog](https://sourcemaking.com/refactoring)
* [Martin Fowler Refactorings catalog](http://refactoring.com/catalog/)
* [CodelyTV Refactoring videos (Spanish)](http://codely.tv/tag/refactoring/)

# Credits and other programming languages

This kata is a PHP port of [the original Incomprehensible Finder Refactoring Kata](https://github.com/OdeToCode/Katas/tree/master/Refactoring) created by [K. Scott Allen](https://github.com/OdeToCode).

You can also find the kata in different programming languages in isolated repositories just ready to clone and enjoy: 
* [Java](https://github.com/DoDevJutsu/incomprehensible-finder-refactoring-java)
* [C#](https://github.com/DoDevJutsu/incomprehensible-finder-refactoring-c-sharp)
* [PHP](https://github.com/CodelyTV/incomprehensible-finder-refactoring-kata)

This port has been developed by [CodelyTV](http://codely.tv/) in order to have it available for the [Software Craftsmanship Barcelona Coding Dojo session](http://www.meetup.com/Barcelona-Software-Craftsmanship/events/233107734/).
Come with us and have some fun if you're near Barcelona the next Monday, August 22nd!
