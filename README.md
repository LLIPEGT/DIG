# Dispenser Inteligente de Grãos (DIG)

## 📖 Sobre o Projeto

O **Dispenser Inteligente de Grãos (DIG)** é uma solução baseada em **Internet das Coisas (IoT)** desenvolvida para automatizar o processo de venda e dispensação de produtos a granel em aviários, lojas de rações e pequenos comércios.

O sistema integra uma aplicação web desenvolvida em **Laravel** com um microcontrolador **ESP32**, permitindo que vendas realizadas no sistema acionem automaticamente um dispenser físico responsável pela liberação dos grãos. Dessa forma, o processo se torna mais rápido, preciso e menos suscetível a erros humanos.

---

## 🎯 Objetivo

Desenvolver um sistema automatizado capaz de controlar remotamente a dispensação de grãos por meio de uma interface web integrada a um microcontrolador ESP32, otimizando o processo de venda e reduzindo desperdícios.

---

## 🚀 Funcionalidades

* Autenticação de usuários (Administrador e Vendedor);
* Cadastro e gerenciamento de usuários;
* Cadastro e gerenciamento de produtos;
* Controle de marcas;
* Controle de estoque;
* Registro e gerenciamento de vendas;
* Geração de comprovantes em PDF;
* Gerenciamento de dispensers;
* Integração com pagamentos via Pix;
* Liberação automática dos produtos após confirmação do pagamento;
* Comunicação entre sistema web e ESP32 via HTTP.

---

## 🏗️ Arquitetura do Sistema

O projeto é dividido em dois componentes principais:

### Sistema Web

Responsável por:

* Gerenciar usuários;
* Controlar produtos e estoque;
* Registrar vendas;
* Processar pagamentos;
* Enviar comandos aos dispensers.

### ESP32

Responsável por:

* Receber requisições HTTP do sistema;
* Processar comandos de liberação;
* Acionar o mecanismo físico de dispensação dos grãos.

---

## 🔄 Fluxo de Funcionamento

```text
Venda
   ↓
Validação dos Dados
   ↓
Confirmação da Venda
   ↓
Pagamento
   ↓
Pagamento Confirmado
   ↓
Envio de Comando para ESP32
   ↓
Liberação dos Grãos
```

## 🛠️ Tecnologias Utilizadas

### Backend

* PHP
* Laravel

### Banco de Dados

* MySQL

### Frontend

* HTML5
* CSS3
* Bootstrap
* JavaScript

### IoT

* ESP32
* HTTP

### Ferramentas

* Git
* GitHub
* GitHub Projects (Kanban)
* Lucidchart
* Miro
* MySQL Workbench

---

## 📋 Requisitos Funcionais

* Login de usuários;
* Cadastro de usuários;
* Cadastro de produtos;
* Cadastro de marcas;
* Controle de vendas;
* Controle de estoque;
* Histórico de vendas;
* Emissão de PDF;
* Controle de dispensers;
* Liberação de produtos;
* Gerenciamento de pagamentos.

---

## 📐 Modelagem

Durante o desenvolvimento foram elaborados:

* Requisitos Funcionais e Não Funcionais;
* Regras de Negócio;
* Diagrama de Casos de Uso;
* Fluxograma do Processo;
* Diagrama de Classes;
* Modelo Entidade-Relacionamento (MER).

---

## 📊 Status do Projeto

### ✅ Concluído

* Levantamento de requisitos;
* Modelagem UML;
* Modelagem do banco de dados;
* Desenvolvimento da interface web;
* Implementação das funcionalidades administrativas;
* Estrutura de comunicação HTTP entre sistema e ESP32.

### 🚧 Em Desenvolvimento

* Implementação da lógica embarcada no ESP32;
* Integração com o mecanismo físico de dispensação;
* Testes em ambiente real.

---

## 🔮 Trabalhos Futuros

* Finalizar a automação física do dispenser;
* Realizar testes de campo em ambiente real;
* Implementar controle inteligente de estoque;
* Criar dashboards e relatórios avançados;
* Adicionar monitoramento remoto dos dispositivos;
* Desenvolver mecanismos de precificação automática.

---

## 👨‍💻 Autores

**Arthur Rodrigues**
[arthurrdgx@gmail.com](mailto:arthurrdgx@gmail.com)

**Fellipe Fernandes Nogueira**
[fellipe.5fernades@gmail.com](mailto:fellipe.5fernades@gmail.com)

**Luiz Carlos Efigênio da Rosa Junior**
[luiz.efigenio@ifpr.edu.br](mailto:luiz.efigenio@ifpr.edu.br)

**Instituto Federal do Paraná (IFPR) – Campus Paranaguá**

---

## 📄 Licença

Projeto desenvolvido para fins acadêmicos no Instituto Federal do Paraná (IFPR).
