# 🤝 Guia de Contribuição - Projeto EducaJá

Primeiramente, obrigado por dedicar seu tempo para contribuir com o **EducaJá**! 🎉 

Este documento estabelece as diretrizes para garantir que o desenvolvimento siga organizado, ágil e acessível para todos. Para garantir que a nossa estilização seja escalável, legível e fácil de manter, adotamos a metodologia **BEM (Block, Element, Modifier)**. Além disso, utilizamos **Commits Semânticos** para manter o repositório padronizado e facilitar a revisão de código em equipe.

---

## 🧭 Sumário

- [Como posso contribuir?](#-como-posso-contribuir)
- [Configurando o Ambiente Local](#-configurando-o-ambiente-local)
- [Padrão de Nomenclatura de Classes CSS (BEM)](#-padrão-de-nomenclatura-de-classes-css-bem)
- [Padrões de Commit Semântico](#-padrões-de-commit-semântico)
- [Estrutura de Branches e Pull Requests](#-estrutura-de-branches-e-pull-requests)

---

## 🛠️ Como posso contribuir?

### 🐛 Reportando Bugs
Se você encontrou um erro de lógica, um problema visual no CSS ou um bug no banco de dados, abra uma **Issue** contendo:
* Passos claros para reproduzir o problema.
* O comportamento esperado vs. o comportamento atual.
* Prints ou mensagens de erro do console.

### ✨ Sugerindo Melhorias
Quer adicionar uma nova animação, uma cor diferente de acessibilidade ou otimizar o PHP? Crie uma **Issue** com a tag `enhancement` e explique como essa mudança beneficia o projeto.

---

## 💻 Configurando o Ambiente Local

Para rodar o sistema na sua máquina e testar suas alterações, siga estes passos:

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/Projeto-EducaJa.git
   cd Projeto-EducaJa
   ```

2. **Configure o Banco de Dados:**
   * Crie um banco de dados no MySQL chamado `educaja_db`.
   * Importe o arquivo `database/schema.sql` (ou equivalente) para criar as tabelas.

3. **Configure as Variáveis de Ambiente:**
   * Faça uma cópia do arquivo `.env.example` e renomeie para `.env`.
   * Preencha com as credenciais do seu banco de dados local.

4. **Inicie o Servidor Local (PHP):**
   ```bash
   php -S localhost:8000
   ```

   > 💡 **Nota:** Certifique-se de acessar `http://localhost:8000` no seu navegador para que o sistema consiga gerenciar as sessões corretamente.

---

## 🎨 Padrão de Nomenclatura de Classes CSS (BEM)

### 📦 Block (Bloco)
É o componente raiz e independente da interface. Deve ter um nome claro que descreva seu propósito.
* **Sintaxe:** `.nome-do-bloco`
* **Exemplos:**
  ```css
  .cabecalho { ... }
  .formulario { ... }
  .cartao { ... }
  ```

### 🧩 Element (Elemento)
É uma parte interna do bloco. Ele não tem significado isolado e está diretamente atrelado ao bloco pai. Para separá-lo do bloco, usamos dois underlines (`__`).
* **Sintaxe:** `.bloco__elemento`
* **Exemplos:**
  ```css
  .cabecalho__titulo { ... }
  .formulario__input { ... }
  .cartao__imagem { ... }
  ```

### 🛠️ Modifier (Modificador)
É uma variação visual ou de estado de um bloco ou de um elemento. Para separá-lo, usamos **dois traços (`--`)**.
* **Sintaxe:** `.bloco--modificador` ou `.bloco__elemento--modificador`
* **Exemplos:**
  ```css
  .botao--primario { ... }
  .cartao--destaque { ... }
  .formulario__input--erro { ... }
  ```

---

## 📝 Padrões de Commit Semântico

Todas as mensagens de commit devem seguir uma estrutura padronizada para manter um histórico limpo e rastreável.

### 🏗️ Estrutura da Mensagem
O formato padrão para cada commit deve ser:

```text
tipo(escopo): descrição curta em letras minúsculas
```

> *(Nota: o uso do escopo entre parênteses é opcional, mas o tipo e a descrição são obrigatórios).*

### 🏷️ Tipos de Commit Permitidos

* ✨ `feat`: Quando uma nova funcionalidade é adicionada ao projeto (ex: criação de uma nova página ou botão).
* 🐛 `fix`: Quando um erro ou bug é corrigido no código existente.
* 📚 `docs`: Quando há mudanças apenas na documentação do projeto (como o README ou este guia).
* 💄 `style`: Alterações que não afetam a lógica do código, apenas a aparência (CSS, formatação de arquivos, espaçamento).
* ♻️ `refactor`: Mudanças no código que melhoram a estrutura ou performance, mas sem alterar o comportamento final.
* 🔧 `chore`: Atualizações de ferramentas de desenvolvimento, instalação de bibliotecas ou configurações de ambiente.

### 💡 Exemplos Práticos para o Grupo

* **Para criar a página inicial:**
  ```bash
  git commit -m "feat: cria estrutura inicial do index.html"
  ```

* **Para mudar as cores do site:**
  ```bash
  git commit -m "style: altera paleta de cores para tons pastéis"
  ```

* **Para corrigir um link quebrado:**
  ```bash
  git commit -m "fix: corrige redirecionamento do menu lateral"
  ```

* **Para atualizar o guia de instalação:**
  ```bash
  git commit -m "docs: atualiza passos de instalação no readme"
  ```

---

## 🔀 Estrutura de Branches e Pull Requests

1. **Crie uma branch a partir da `main` para a sua alteração:**
   ```bash
   git checkout -b feature/minha-nova-tela
   ```

2. **Faça seus commits seguindo o padrão semântico detalhado acima.**

3. **Envie para o repositório remoto:**
   ```bash
   git push origin feature/minha-nova-tela
   ```

4. **Abra um Pull Request (PR)** detalhando o que foi feito para que a equipe possa revisar.

---

Obrigado por ajudar a tornar o aprendizado mais acessível e personalizável! 🚀