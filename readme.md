# Clínica Saúde  Instruções de instalação

> Este README explica como preparar o ambiente local usando o USBWebserver e importar o banco de dados para executar o projeto PHP `clinica_saude`.

Passos resumidos:
- Clonar o repositório
- Baixar e extrair o USBWebserver com PHP 8.1.3
- Colocar o código dentro da pasta `root` do USBWebserver
- Executar o USBWebserver (iniciar Apache e MySQL)
- Criar a base de dados `clinica_saude` e importar `sql/clinica_saude.sql`
- Iniciar o servidor web embutido do PHP (`php -S localhost:8000 -t .`)
- Abrir `localhost:8000/index.php` no navegador

---

1) Clonar repositório

- Abra o PowerShell e execute (ou use seu cliente Git preferido):

```powershell
git clone https://github.com/giselecampo/clinica_saude_etec.git
cd clinica_saude_etec
```

2) Baixar USBWebserver (com PHP 8.1.3)

- Acesse: https://usbwebserver.yura.mk.ua/
- Baixe a versão do USBWebserver compatível com **PHP 8.1.3** (verifique no instalador/descrição a versão do PHP incluída).
- Extraia o conteúdo do ZIP em algum local (ex.: `C:\usbwebserver_v8.6.5`).

3) Posicionar o projeto na pasta web

- Copie (ou mova) o conteúdo da pasta `clinica_saude_etec` para a pasta `root` do USBWebserver, renomeando a pasta final para `clinica_saude`. Exemplo de caminhos:

```
C:\usbwebserver_v8.6.5\usbwebserver\root\clinica_saude\  <-- aqui deve estar o conteúdo do projeto
```

4) Iniciar USBWebserver e abrir phpMyAdmin

- Abra o executável do USBWebserver e inicie os serviços **Apache** e **MySQL** pelo painel.
- Na aba "Configurações" (Settings), verifique a porta do MySQL (padrão `3306`). 
- No navegador abra o phpMyAdmin.

5) Login no phpMyAdmin (credenciais padrão do USBWebserver)

- **Usuário:** `root`
- **Senha:** `usbw`

6) Criar a base de dados `clinica_saude`

- No phpMyAdmin clique na aba **"Base de Dados"** (ou "Databases").
- Em "Criar base de dados" digite `clinica_saude` e clique em "Criar".

7) Importar o arquivo `clinica_saude.sql`

- Na lista de bases de dados, selecione `clinica_saude` criada.
- Vá em **Importar**  escolha o arquivo `sql/clinica_saude.sql` dentro do repositório clonado e clique em importar.

Observação: o dump SQL que acompanha o projeto define tabelas e dados de exemplo (inclui um usuário administrador).

8. Iniciar o servidor web e acessar o projeto

- Certifique-se que o Apache e MySQL estão rodando no USBWebserver.

- Abra o PowerShell, navegue até a pasta do projeto e inicie o servidor embutido do PHP:

```powershell
# Exemplo: inicia o servidor embutido na porta 8000
C:\Users\User\dev\usbwebserver\php\php.exe -S localhost:8000 -t .
```

- No navegador, acesse: `http://localhost:8000/index.php` (ou a porta que você escolheu).

- Caso haja um erro de conexão com o banco de dados, faça download do [Visual C++ Redistributable Packages for Visual Studio 2013](https://www.microsoft.com/en-us/download/details.aspx?id=40784) e instale (necessário para o driver MySQL do PHP).
