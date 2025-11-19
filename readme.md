# Clínica Saúde  Instruções de instalação (pt-BR)

> Este README explica como preparar o ambiente local usando o USBWebserver e importar o banco de dados para executar o projeto PHP `clinica_saude`.

Passos resumidos:
- Clonar o repositório
- Baixar e extrair o USBWebserver com PHP 8.3.12
- Colocar o código dentro da pasta `root` do USBWebserver
- Criar a base de dados `clinica_saude` e importar `sql/clinica_saude.sql`
- Ajustar `config/database.php` se necessário
- Abrir `index.php` no navegador

---

1) Clonar repositório

Abra o PowerShell e execute (ou use seu cliente Git preferido):

```powershell
git clone https://github.com/giselecampo/clinica_saude_etec.git
cd clinica_saude_etec
```

2) Baixar USBWebserver (com PHP 8.3.12)

- Acesse: https://usbwebserver.yura.mk.ua/
- Baixe a versão do USBWebserver compatível com **PHP 8.3.12** (verifique no instalador/descrição a versão do PHP incluída).
- Extraia o conteúdo do ZIP em algum local (ex.: `C:\usbwebserver_v8.6.5`).

3) Posicionar o projeto na pasta web

- Copie (ou mova) o conteúdo da pasta `clinica_saude_etec` para a pasta `root` do USBWebserver, renomeando a pasta final para `clinica_saude`. Exemplo de caminhos:

```
C:\usbwebserver_v8.6.5\usbwebserver\root\clinica_saude\  <-- aqui deve estar o conteúdo do projeto
```

4) Iniciar USBWebserver e abrir phpMyAdmin

- Abra o executável do USBWebserver e inicie os serviços **Apache** e **MySQL** pelo painel.
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
- Alternativa via linha de comando (PowerShell) se `mysql` estiver no PATH:

```powershell
cd "C:\usbwebserver_v8.6.5\usbwebserver\root\clinica_saude"
mysql -u root -pusbw clinica_saude < .\sql\clinica_saude.sql
```

Observação: o dump SQL que acompanha o projeto define tabelas e dados de exemplo (inclui um usuário administrador).
