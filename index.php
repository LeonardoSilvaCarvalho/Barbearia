<!-- PHP INCLUDES -->

<?php

include "connect.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";

?>

<!-- SEÇÃO INICIAL -->

<section class="home-section" id="home-section">
    <div class="home-section-content">
        <div id="home-section-carousel" class="carousel slide" data-ride="carousel">
<!--            <ol class="carousel-indicators">-->
<!--                <li data-target="#home-section-carousel" data-slide-to="0" class="active"></li>-->
<!--                <li data-target="#home-section-carousel" data-slide-to="1"></li>-->
<!--                <li data-target="#home-section-carousel" data-slide-to="2"></li>-->
<!--            </ol>-->
            <div class="carousel-inner">
                <!-- FIRST SLIDE -->
                <div class="carousel-item active">
                    <img class="d-block w-100" style="background: rgba(0, 0, 0, 0.8)!important; filter: brightness(50%);" src="Design/images/barbershop_image_1.jpg" alt="First slide">
                    <div class="carousel-caption d-md-block">
                        <h3>Transforme seu visual com cortes de precisão na Barbearia Tchelos</h3>
                        <p>
                            onde estilo e tradição se encontram.
                            <br>
                        </p>
                    </div>
                </div>
                <!-- SECOND SLIDE -->
                <div class="carousel-item">
                    <img class="d-block w-100" style="background: rgba(0, 0, 0, 0.8)!important; filter: brightness(50%);" src="Design/images/barbershop_image_2.jpg" alt="Second slide">
                    <div class="carousel-caption d-md-block">
                        <h3>Na Barbearia Tchelos, cada corte é uma obra de arte</h3>
                        <p>
                            feito por mãos habilidosas e apaixonadas pela tradição da barbearia
                        </p>
                    </div>
                </div>
                <!-- THIRD SLIDE -->
                <div class="carousel-item">
                    <img class="d-block w-100" style="background: rgba(0, 0, 0, 0.8)!important; filter: brightness(50%);" src="Design/images/barbershop_image_3.jpg" alt="Third slide">
                    <div class="carousel-caption d-md-block">
                        <h3>Descubra o verdadeiro significado de cuidado masculino na Barbearia Tchelos</h3>
                        <p>
                            onde tradição, elegância e excelência se unem para criar experiências únicas
                        </p>
                    </div>
                </div>
            </div>
            <!-- PREVIOUS & NEXT -->
            <a class="carousel-control-prev" href="#home-section-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#home-section-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Proximo</span>
            </a>
        </div>
    </div>
</section>

<!-- SOBRE A SEÇÃO -->

<section id="about" class="about_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="about_content" style="text-align: center;">
                    <h3>Nós somos para você</h3>
                    <h2>Sua Barbearia de Confiança</h2>
                    <img src="Design/images/about-logo.jpg" alt="logo" width="50%">
                    <p style="color: #777">
                        Somos uma barbearia dedicada aos nossos clientes. Antes de começar, analisamos sua fisionomia para recomendar o melhor corte para você.
                        Sempre respeitando ao máximo sua opinião, seus gostos e preferências.
                    </p>
                    <a href="appointment.php" class="default_btn" style="opacity: 1;">Reserve um horario</a>
                </div>
            </div>
            <div class="col-md-6  d-none d-md-block">
                <div class="about_img" style="overflow:hidden">
                    <img class="about_img_1" src="Design/images/about-1.jpg" alt="about-1" style="background: rgba(0, 0, 0, 0.8)!important; filter: brightness(50%); border-radius: 20px">
                    <img class="about_img_2" src="Design/images/about-2.jpg" alt="about-2" style="background: rgba(0, 0, 0, 0.8)!important; filter: brightness(50%); border-radius: 20px">
                    <img class="about_img_3" src="Design/images/about-3.jpg" alt="about-3" style="background: rgba(0, 0, 0, 0.8)!important; filter: brightness(50%); border-radius: 20px">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO DE SERVIÇOS -->

<section class="services_section" id="services">
    <div class="container">
        <div class="section_heading">
            <h3>Nós somos a sua Barbearia</h3>
            <h2>Nossos serviços</h2>
            <div class="heading-line"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-scissors-1"></i>
                    <h3>Corte cabelo</h3>
                    <p>Os melhores cortes de cabelo adaptados ao formato do seu rosto</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-razor-2"></i>
                    <h3>Corte barba</h3>
                    <p>Ajustamos à sua barba, damos-lhe os melhores conselhos possíveis.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-brush"></i>
                    <h3>Barba terapia</h3>
                    <p>Incluímos um tratamento, cremes e bálsamos que cuidam da sua pele.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-hairbrush-1"></i>
                    <h3>Serviços de Química</h3>
                    <p>Oferecemos os melhores tratamentos para pintura, alisamento e outros procedimentos químicos,
                        cuidando do seu cabelo e garantindo resultados incríveis.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO DE RESERVAS -->

<!--<section class="book_section" id="booking">-->
<!--    <div class="book_bg"></div>-->
<!--    <div class="map_pattern"></div>-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-6 offset-md-6">-->
<!--                <form action="appointment.php" method="post" id="appointment_form" class="form-horizontal appointment_form">-->
<!--                    <div class="book_content">-->
<!--                        <h2 style="color: white;">Agende seu horário</h2>-->
<!--                        <p style="color: #999;">-->
<!--                            Em alguns passos simples, basta escolher a data <br>e você poderá agendar seu horário sem problemas.-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div class="form-group row">-->
<!--                        <div class="col-md-6 padding-10">-->
<!--                            <input type="date" class="form-control">-->
<!--                        </div>-->
<!--                        <div class="col-md-6 padding-10">-->
<!--                            <input type="time" class="form-control">-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <!- SUBMIT BUTTON -->
<!---->
<!--                    <button id="app_submit" class="default_btn" type="submit">-->
<!--                        Agende seu horário-->
<!--                    </button>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->

<!-- SEÇÃO GALERIA -->

<section class="gallery-section" id="gallery">
    <div class="section_heading">
        <h3>Nós somos a sua Barbearia</h3>
        <h2>Alguns de nossos serviços</h2>
        <div class="heading-line"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-1.jpg');"> </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-2.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-3.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-4.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-5.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-6.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-7.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-8.jpg');"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO DA EQUIPE-->

<section id="team" class="team_section">
    <div class="container">
        <div class="section_heading ">
            <h3>Nós somos a sua Barbearia</h3>
            <h2>Nossos Barbeiros</h2>
            <div class="heading-line"></div>
        </div>
        <ul class="team_members row" style="justify-content: center">
            <li class="col-lg-4 col-md-3 padd_col_res">
                <div class="team_member">
                    <img src="Design/images/team-1.jpg" alt="Team Member" height="400">
                    <h3 class="text-center mt-1">Marcelo Moraes</h3>
                </div>
            </li>
            <li class="col-lg-4 col-md-3 padd_col_res">
                <div class="team_member">
                    <img src="Design/images/team-2.jpg" alt="Team Member" height="400">
                    <h3 class="text-center mt-1">Henrique Silva</h3>
                </div>
            </li>
        </ul>
    </div>
</section>

<!-- SEÇÃO DE AVALIAÇÕES -->

<section id="reviews" class="testimonial_section">
    <div class="container">
        <div id="reviews-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <!-- REVIEW 3 -->
                <div class="carousel-item active">
                    <img class="d-block w-100" src="Design/images/barbershop_image_1.jpg" alt="First slide" style="visibility: hidden;">
                    <div class="carousel-caption d-md-block">
                        <h3>Descubra o poder de um corte de cabelo impecável na Barbearia Tchelos</h3>
                        <p>
                            onde cada detalhe é cuidadosamente refinado para realçar sua confiança e estilo
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO DE PREÇOS  -->

<section class="pricing_section" id="pricing">

    <!-- COMECE A OBTER PREÇOS DE CATEGORIAS DO BANCO DE DADOS -->

    <?php

    $stmt = $con->prepare("Select * from service_categories");
    $stmt->execute();
    $categories = $stmt->fetchAll();

    ?>

    <!-- FIM -->

    <div class="container">
        <div class="section_heading">
            <h3>Nós somos a sua Barbearia</h3>
            <h2>Nossos Preços</h2>
            <div class="heading-line"></div>
        </div>
        <div class="row">
            <?php

            foreach ($categories as $category) {
                $stmt = $con->prepare("Select * from services where category_id = ?");
                $stmt->execute(array($category['category_id']));
                $totalServices =  $stmt->rowCount();
                $services = $stmt->fetchAll();

                if ($totalServices > 0) {
            ?>

                    <div class="col-lg-4 col-md-6 sm-padding">
                        <div class="price_wrap">
                            <h3><?php echo $category['category_name'] ?></h3>
                            <ul class="price_list">
                                <?php

                                foreach ($services as $service) {
                                ?>

                                    <li>
                                        <h4><?php echo $service['service_name'] ?></h4>
                                        <p><?php echo $service['service_description'] ?></p>
                                        <span class="price">R$<?php echo $service['service_price'] ?></span>
                                    </li>

                                <?php
                                }

                                ?>

                            </ul>
                        </div>
                    </div>

            <?php
                }
            }

            ?>

        </div>
    </div>
</section>

<!-- SEÇÃO DE CONTATO -->

<section class="contact-section" id="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 sm-padding">
                <div class="contact-info">
                    <h2>
                        Se você tiver alguma dúvida,
                        <br>envie-nos uma mensagem hoje mesmo!
                    </h2>
                    <p>
                        Estamos muito atentos aos nossos clientes e as suas dúvidas ou sugestões são muito importantes para nós.
                    </p>
                    <h4>
                        <span style="font-weight: bold; font-size: 16px;">Endereço:</span>
                        Rua Eugênio Egas 253, jardim climax
                        <br>
                        SP, São Paulo
                    </h4>
                    <h4>
                        <span style="font-weight: bold; font-size: 18px">Telefone:</span>
                        <a href="https://api.whatsapp.com/send?phone=5511965244393" target="_blank" style="color: #000; font-size: 16px">
                            +55 (11)96524-4393
                            <i class="fab fa-whatsapp" style="color: #25D366; margin-left: 5px; font-size: 40px;"></i>
                        </a>
                        <br>
                    </h4>
                </div>
            </div>
            <div class="col-lg-6 sm-padding">
                <div class="contact-form">
                    <div id="contact_ajax_form" class="contactForm">
                        <div class="form-group colum-row row">
                            <div class="col-sm-6">
                                <input type="text" id="contact_name" name="name" class="form-control" placeholder="Seu Nome">
                            </div>
                            <div class="col-sm-6">
                                <input type="email" id="contact_email" name="email" class="form-control" placeholder="Seu email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="Assunto">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="contact_message" name="message" cols="30" rows="5" class="form-control message" placeholder="Mensagem"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button id="contact_send" class="default_btn">Envie sua mensagem</button>
                            </div>
                        </div>
                        <img src="Design/images/ajax_loader_gif.gif" id="contact_ajax_loader" style="display: none">
                        <div id="contact_status_message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO / RODAPÉ DO WIDGET -->

<section class="widget_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer_widget">
                    <img src="Design/images/logo.jpg" alt="Brand" style="border-radius: 15px; width: 150px; height: 100px; margin-bottom: 5px;margin-left: 30px">
                    <p>
                        Somos a sua melhor opção, o nosso maior capital o seu conforto e satisfação
                    </p>
                    <ul class="widget_social">
                        <li><a href="https://www.facebook.com/profile.php?id=100038919447190" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f fa-2x" style="color: #3b5998;"></i></a></li>
                        <li><a href="https://www.instagram.com/barbearia_tchelos/" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram fa-2x" style="color: #833ab4;"></i></a></li>
                        <li><a href="https://api.whatsapp.com/send?phone=5511965244393" data-toggle="tooltip" title="WhatsApp"><i class="fab fa-whatsapp" style="color: #25D366; margin-left: 5px; font-size: 24px;"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer_widget">
                    <h3>Endereço:</h3>
                    <p>
                        rua Eugênio egas 253, São Paulo, SP, Brazil
                    </p>
                    <p>
                        <a href="https://api.whatsapp.com/send?phone=5511965244393" target="_blank" style="color: #fff; font-size: 16px" data-toggle="tooltip" title="WhatsApp">
                            +55 (11)96524-4393
                            <i class="fab fa-whatsapp" style="color: #25D366; margin-left: 5px; font-size: 24px;"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer_widget">
                    <h3>
                        Horarios Disponiveis
                    </h3>
                    <ul class="opening_time">
                        <li>Segunda a Sabado - 09:00am - 22:00pm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER  -->

<?php include "./Includes/templates/footer.php"; ?>