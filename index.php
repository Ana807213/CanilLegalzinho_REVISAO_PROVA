
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" /> <!-- Define o charset da página -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!-- Responsividade -->
  <title>Canil Legalzinho</title> <!-- Título da página -->
  <style>
    * {
      margin: 0; /* Remove margens padrão */
      padding: 0; /* Remove espaçamentos padrão */
      box-sizing: border-box; /* Inclui borda e padding no tamanho total */
    }

    body {
      font-family: Arial, sans-serif; /* Fonte principal */
      background: #f8f3f6; /* Cor de fundo */
      color: #333; /* Cor do texto */
    }

    header {
      background: #ffffff; /* Fundo do cabeçalho */
      display: flex; /* Layout flexível */
      justify-content: space-between; /* Espaço entre logo e navegação */
      align-items: center; /* Alinha verticalmente */
      padding: 1rem 2rem; /* Espaçamento interno */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
      position: sticky; /* Fixa no topo ao rolar */
      top: 0; /* Topo da página */
      z-index: 999; /* Sobrepõe outros elementos */
    }

    .hero-nav {
      display: flex; /* Layout flexível */
      gap: 1rem; /* Espaço entre links */
    }

    .hero-nav a {
      text-decoration: none; /* Remove sublinhado */
      color: #444; /* Cor dos links */
      font-weight: bold; /* Negrito */
    }

    .hero-nav a:hover {
      color: #da70d6; /* Cor ao passar o mouse */
    }

    .hero-banner {
      display: flex; /* Layout flexível */
      flex-direction: column; /* Coluna em telas pequenas */
      align-items: center; /* Centraliza conteúdo */
      text-align: center; /* Centraliza texto */
      padding: 3rem 1rem; /* Espaçamento interno */
      background-color: #fff0f5; /* Fundo da seção */
    }

    .hero-banner h1 {
      font-size: 2rem; /* Tamanho do título */
      margin-bottom: 1rem; /* Espaço abaixo */
      color: #da70d6; /* Cor do título */
    }

    .hero-banner p {
      font-size: 1rem; /* Tamanho do texto */
      max-width: 600px; /* Largura máxima */
      margin-bottom: 2rem; /* Espaço abaixo */
    }

    .cta-button {
      background: #da70d6; /* Cor de fundo */
      color: #fff; /* Cor do texto */
      padding: 1rem 2rem; /* Espaçamento interno */
      font-size: 1rem; /* Tamanho da fonte */
      border: none; /* Sem borda */
      border-radius: 25px; /* Borda arredondada */
      cursor: pointer; /* Cursor de clique */
      transition: background 0.3s; /* Transição suave */
    }

    .cta-button:hover {
      background: #c25cc2; /* Cor ao passar o mouse */
    }

    .pet-card-oferta {
      display: flex; /* Layout flexível */
      flex-wrap: wrap; /* Quebra linha se necessário */
      gap: 2rem; /* Espaço entre cards */
      justify-content: center; /* Centraliza cards */
      padding: 2rem 1rem; /* Espaçamento interno */
    }

    .pet-card {
      background: #fff; /* Fundo branco */
      border-radius: 12px; /* Borda arredondada */
      padding: 1rem; /* Espaçamento interno */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
      text-align: center; /* Centraliza texto */
      width: 280px; /* Largura fixa */
    }

    .pet-card h3 {
      margin: 1rem 0 0.5rem; /* Espaçamento acima e abaixo */
      color: #da70d6; /* Cor do nome do pet */
    }

    .pet-card p {
      font-size: 0.9rem; /* Tamanho do texto */
      color: #555; /* Cor do texto */
    }

    .garantia {
      display: flex; /* Layout flexível */
      flex-direction: column; /* Coluna em telas pequenas */
      align-items: center; /* Centraliza conteúdo */
      padding: 2rem 1rem; /* Espaçamento interno */
      background: #fff; /* Fundo branco */
      text-align: center; /* Centraliza texto */
    }

    .garantia h2 {
      color: #da70d6; /* Cor do título */
      margin-bottom: 1rem; /* Espaço abaixo */
    }

    .garantia p {
      max-width: 600px; /* Largura máxima */
    }

    .blog-carrossel {
      padding: 2rem 1rem; /* Espaçamento interno */
      background: #f0e6f6; /* Fundo da seção */
      text-align: center; /* Centraliza texto */
    }

    .blog-carrossel h2 {
      margin-bottom: 1rem; /* Espaço abaixo */
      color: #9932cc; /* Cor do título */
    }

    .slides {
      display: flex; /* Layout flexível */
      gap: 1rem; /* Espaço entre slides */
      overflow-x: auto; /* Rolagem horizontal */
      scroll-snap-type: x mandatory; /* Snap nos slides */
      padding-bottom: 1rem; /* Espaço abaixo */
    }

    .slide {
      flex: 0 0 80%; /* Largura dos slides em telas pequenas */
      background: #fff; /* Fundo branco */
      border-radius: 12px; /* Borda arredondada */
      padding: 1rem; /* Espaçamento interno */
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Sombra */
      scroll-snap-align: center; /* Snap centralizado */
    }

    .slide h3 {
      color: #da70d6; /* Cor do título do slide */
      margin-bottom: 0.5rem; /* Espaço abaixo */
    }

    .slide p {
      font-size: 0.9rem; /* Tamanho do texto */
    }

    footer {
      background: #333; /* Fundo escuro */
      color: #fff; /* Cor do texto */
      text-align: center; /* Centraliza texto */
      padding: 1rem; /* Espaçamento interno */
    }

    footer p {
      margin: 0; /* Remove margem */
    }

    @media (min-width: 768px) {
      .hero-banner {
        flex-direction: row; /* Linha em telas grandes */
        justify-content: space-between; /* Espaço entre elementos */
        text-align: left; /* Alinha texto à esquerda */
        padding: 4rem 6rem; /* Espaçamento maior */
      }

      .garantia {
        flex-direction: row; /* Linha em telas grandes */
        justify-content: center; /* Centraliza conteúdo */
        gap: 2rem; /* Espaço entre elementos */
        text-align: left; /* Alinha texto à esquerda */
      }

      .slides {
        gap: 2rem; /* Espaço maior entre slides */
      }

      .slide {
        flex: 0 0 30%; /* Slides mais estreitos em telas grandes */
      }
    }
  </style>
</head>
<body>
  <header>
    <!-- Logo removida -->
    <nav class="hero-nav">
        <a href="index.php">Home</a> <!-- Link para a página inicial -->
        <a href="caes_disponiveis.php">Cães Disponíveis</a> <!-- Link para cães -->
        <a href="#">Sobre</a> <!-- Link para sobre -->
        <a href="#">Contato</a> <!-- Link para contato -->
    </nav>
    <h1>Canil Legalzinho</h1> <!-- Nome do canil -->
  </header>

  <section class="hero-banner">
    <div>
      <h1>Encontre seu novo melhor amigo</h1> <!-- Título principal -->
      <p>Descubra os mais adoráveis e saudáveis filhotes prontos para fazer parte da sua família!</p> <!-- Descrição -->
      <button class="cta-button">Ver Filhotes</button> <!-- Botão de chamada para ação -->
    </div>
    <div class="hero-pet-card">
      <!-- Imagem principal removida -->
    </div>
  </section>

  <section class="pet-card-oferta">
    <!-- Cards de pets sem imagem -->
    <div class="pet-card">
      <h3>Golden Retriever</h3> <!-- Nome do pet -->
      <p>3 meses - Vacinado e Vermifugado</p> <!-- Informações do pet -->
    </div>
    <div class="pet-card">
      <h3>Shih Tzu</h3> <!-- Nome do pet -->
      <p>2 meses - Pelagem Premium</p> <!-- Informações do pet -->
    </div>
  </section>

  <section class="garantia">
    <!-- Imagem de garantia removida -->
    <div>
      <h2>Garantia de Saúde e Procedência</h2> <!-- Título da garantia -->
      <p>Todos os nossos filhotes são entregues com garantia de saúde, carteira de vacinação atualizada e acompanhamento veterinário.</p> <!-- Texto da garantia -->
    </div>
  </section>

  <section class="blog-carrossel">
    <h2>Dicas e Cuidados</h2> <!-- Título do blog -->
    <div class="slides">
      <div class="slide">
        <h3>Como alimentar seu filhote</h3> <!-- Título do slide -->
        <p>Dicas essenciais sobre alimentação saudável para seu novo amiguinho.</p> <!-- Texto do slide -->
      </div>
      <div class="slide">
        <h3>Primeiros cuidados em casa</h3> <!-- Título do slide -->
        <p>O que fazer nos primeiros dias com seu novo cãozinho.</p> <!-- Texto do slide -->
      </div>
      <div class="slide">
        <h3>Vacinação e Vermifugação</h3> <!-- Título do slide -->
        <p>Entenda o calendário de vacinas e cuidados essenciais.</p> <!-- Texto do slide -->
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 Canil Legalzinho. Todos os direitos reservados.</p> <!-- Rodapé -->
  </footer>
</body>
</html>

