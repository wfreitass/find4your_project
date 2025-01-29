# 📌 Find4Your Project
🚀 Um sistema desenvolvido com Laravel seguindo boas práticas como Repository Pattern, Service Layer, Interfaces e Enum, além de testes unitários para garantir qualidade e confiabilidade.

## 🛠️ Tecnologias Utilizadas
- Laravel (Framework PHP)
- PostgreSQL (Banco de Dados)
- Redis (Cache e filas)
- Docker (Ambiente de desenvolvimento)
- Elasticsearch (Busca avançada)
- PHPUnit (Testes unitários)

## 📂 Arquitetura do Projeto
O projeto segue uma arquitetura baseada em boas práticas, separando responsabilidades e garantindo manutenibilidade e testabilidade.

### 🔹 Repository Pattern
Utilizamos Repositories para desacoplar a lógica de acesso ao banco de dados do restante da aplicação. Isso melhora a reutilização do código e facilita a troca de implementação se necessário

🔹 Service Layer
Os Services encapsulam a lógica de negócio da aplicação, garantindo que os Controllers fiquem enxutos e mais focados em gerenciar requisições e respostas.

🔹 Interfaces
Para garantir a inversão de dependência (SOLID - D), todas as classes possuem uma Interface correspondente, o que facilita a manutenção e permite trocar implementações sem modificar o código-fonte principal.

🔹 Enum
O uso de Enums melhora a legibilidade e a integridade dos dados, evitando o uso de valores "mágicos" espalhados pelo código.

Testes Unitários
O projeto implementa testes unitários com PHPUnit para garantir a qualidade e funcionamento correto das funcionalidades.