<?php include('navbar_usuario.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Meu Site</title>
  <link rel="icon" type="image/x-icon" href="IMG/9b0af5bc-9c00-412e-903f-6c74f12cdbf0.ico">
  <link rel="stylesheet" href="Sobre.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    .info {
      display: flex;
      align-items: center;
      margin-bottom: 3rem;
      gap: 2rem;
    }

    .info:nth-child(even) {
      flex-direction: row-reverse;
    }

    .info img {
      width: 300px;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .info h2 {
      font-size: 1.8rem;
      color: #333;
    }

    .info p {
      font-size: 1rem;
      line-height: 1.6;
      color: #555;
    }
  </style>
</head>
<body>
  <?php include 'navbar_usuario.php'; ?> <!-- Incluindo a navbar -->
  <div class="main-content">
    <!-- Vacinação de Pequenos Animais -->
    <section class="info" data-aos="fade-right" data-aos-duration="1000">
      <img src="IMG/Cachorro.jpg" alt="Cão recebendo vacina">
      <div>
        <h2>Vacinação de Pequenos Animais</h2>
        <p>
          A vacinação em pequenos animais, como cães e gatos, é essencial para protegê-los contra doenças graves como:
        </p>
        <ul>
          <li><strong>Raiva:</strong> Uma zoonose fatal que pode ser transmitida para humanos.</li>
          <li><strong>Cinomose:</strong> Afeta o sistema nervoso, podendo levar à morte.</li>
          <li><strong>Parvovirose:</strong> Doença altamente contagiosa que causa diarreia grave.</li>
        </ul>
      </div>
    </section>

    <!-- Vacinação de Grandes Animais -->
    <section class="info" data-aos="fade-left" data-aos-duration="1000">
      <img src="IMG/Gado.jpg" alt="Vacinação de gado">
      <div>
        <h2>Vacinação de Grandes Animais</h2>
        <p>
          Bovinos, equinos e outros grandes animais precisam de imunização regular para garantir sua saúde e evitar surtos de doenças. Entre as vacinas importantes, destacam-se:
        </p>
        <ul>
          <li><strong>Febre Aftosa:</strong> Previne a disseminação dessa doença viral entre bovinos.</li>
          <li><strong>Tétano:</strong> Comum em equinos, pode ser evitado com vacinação anual.</li>
          <li><strong>Clostridioses:</strong> Protege contra infecções bacterianas graves.</li>
        </ul>
      </div>
    </section>

    <!-- Benefícios Gerais da Vacinação -->
    <section class="info" data-aos="fade-right" data-aos-duration="1000">
      <img src="IMG/Exame.jpg" alt="Veterinário examinando animal">
      <div>
        <h2>Benefícios da Vacinação</h2>
        <p>
          A vacinação regular promove:
        </p>
        <ul>
          <li>Redução do risco de transmissão de zoonoses.</li>
          <li>Maior longevidade e qualidade de vida para os animais.</li>
          <li>Contribuição para o controle de surtos em comunidades rurais e urbanas.</li>
        </ul>
      </div>
    </section>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      offset: 120, /* Ajustar altura de início */
      delay: 100, /* Atraso para as animações */
      duration: 1000 /* Duração da animação */
    });
  </script>
  <?php include('footer.php'); ?>
</body>
</html>



