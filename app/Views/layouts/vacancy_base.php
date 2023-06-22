<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PELAMAR</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css" integrity="sha512-z/90a5SWiu4MWVelb5+ny7sAayYUfMmdXKEAbpj27PfdkamNdyI3hcjxPxkOPbrXoKIm7r9V2mElt5f1OtVhqA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        html, body{
            margin: 0;
            padding: 0;
            height:100%;
            width:100%;
        }
        .navbar{   
            background-color: #054D6E !important;   
        }
        .text-light{
            
            font-size: 16px;
            font-weight: bold !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        button#user-topnav-menu {
            background: #fff;
            border: 1px solid #b1b1b1;
            padding: 0.2em 2em;
            text-align: right !important;
            border-radius: 2em;
        }
        .spasi {
        display: inline-block;
        width: 10px;
        }
        .navbar-brand{
            font-size: 24px;
            font-weight: bold !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        @media print{
            .col-lg-6,.col-md-6{
                width:50%;
            }
            .lh-1{
                line-height:1em;
            }
        }
        .truncate-5 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
        }
    </style>
    <?= $this->renderSection('custom_css') ?>

</head>
<body class="bg-dark bg-gradient bg-opacity-25">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark bg-gradient">
    <div class="container">
      <a class="navbar-brand" href="#">Web Recruitment</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="<?= base_url('Auth/') ?>" class="text-light text-decoration-none fw-light">Perusahan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    
    <div class="container py-4">
            <?php if($session->getFlashdata('main_error')): ?>
                <div class="alert alert-danger rounded-0">
                    <?= $session->getFlashdata('main_error') ?>
                </div>
            <?php endif; ?>
            <?php if($session->getFlashdata('main_success')): ?>
                <div class="alert alert-success rounded-0">
                    <?= $session->getFlashdata('main_success') ?>
                </div>
            <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </div>
</body>
<?= $this->renderSection('custom_js') ?>
</html>