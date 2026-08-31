# Guia de Contribuição - Oktano

Este documento estabelece as diretrizes para garantir que o desenvolvimento siga organizado, ágil e acessível para todos. Para garantir que o nosso código seja escalável, legível e fácil de manter, utilizamos **Commits Semânticos** para manter o repositório padronizado e facilitar a revisão em equipe.

---

## Reportando Bugs

Se você encontrou um erro de lógica, um problema visual no CSS ou um bug no banco de dados, abra uma **Issue** contendo:

*   **Passos claros** para reproduzir o problema.
*   O **comportamento esperado** *vs.* o **comportamento atual**.
*   **Prints de tela** ou mensagens de erro do console.

---

## Padrões de Commit Semântico

Todas as mensagens de commit devem seguir uma estrutura padronizada para manter um histórico limpo e rastreável. 

### Estrutura da Mensagem

O formato padrão para cada commit deve ser:

> `tipo(escopo): descrição curta em letras minúsculas`

### Tipos de Commit Permitidos

| Tipo | Descrição |
| :--- | :--- |
| **feat** | Nova funcionalidade adicionada ao projeto (ex: criação de uma nova página ou botão). |
| **fix** | Correção de um erro ou bug no código existente. |
| **docs** | Mudanças apenas na documentação do projeto (como o README ou este guia). |
| **style** | Alterações que não afetam a lógica, apenas a aparência (CSS, formatação, espaçamento). |
| **refactor** | Mudanças no código que melhoram a estrutura ou performance, sem alterar o comportamento final. |
| **chore** | Atualizações de ferramentas, instalação de bibliotecas ou configurações de ambiente. |

---
