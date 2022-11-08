# Sobre o projeto

O intuito do projeto foi aperfeiçoar os conhecimentos sobre arquitetura de software. O objetivo era fazer uma 
api de autenticação que utilizasse JWT para autorização.

Com isso, tentei aplicar os conceitos de Clean Architecture e acredito que tenha conseguido um resultado bem
satisfatório, onde consegui encapsular a Entity e isolar as camadas de infra e de apresentação.

Conforme o projeto foi evoluindo consegui identificar vários pontos de melhoria, começando pela solução de 
[erros](src/Domain/Entities/Error.php) presente na entity [User](src/Domain/Entities/User.php). 
Tentei seguir o padrão [Dont Use Exceptions For Flow Control](https://wiki.c2.com/?DontUseExceptionsForFlowControl)
usando como referência a forma de tratamento de erros presente na linguagem Go, porém não gostei muito 
do resultado, acredito que não ficou intuitivo, pois requer uma validação sempre que interagir com uma
Entity. Creio que se eu usasse Exeption para validar os dados da Entity o código ficaria menos complexo
e menos suscetível a erros, por exemplo, caso a pessoa esquecesse de validar a Entity após realizar uma interação, 
apesar de a solução escolhida ter funcionado como proposto.

Acredito que a implementação do [UserInMemoryRepository](src/Infrastructure/Repository/UserInMemoryRepository.php) poderia ter sido de outra forma,
pois a forma escolhida duplicou o código presente na classe [UserSQLiteRepository](src/Infrastructure/Repository/UserSQLiteRepository.php).

Um ponto positivo que gostei bastante foi implementar com sucesso a inversão de dependências em conjunto com
a injeção de dependência, usado principalmente nos Controllers.

Um bom ponto de melhoria pessoal é a questão de realizar commits menores, eu comecei bem, porém com a evolução
do projeto eu mudava de ideia constantemente quando me deparava com algumas decisões por não ter planejado
por qual caminho seguir antes de iniciar o projeto, e isso me fez perder o controle dos commits.

Foi um projeto bem divertido e interessante de produzir, consegui praticar muitos conceitos, dando foco
principalmente na arquitetura e em testes unitários, testando ideias e descobrindo que muitas delas não
funcionam muito bem dependendo da situação 😅
