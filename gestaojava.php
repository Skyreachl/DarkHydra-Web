<?php
    session_start();

    if(!isset($_SESSION['LOGGED'])) {
        header('location:indexjava.php');
    } else if($_SESSION['TIPO'] != "admin" && $_SESSION['TIPO'] != "gestor") {
        header('location:indexjava.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Plataforma de games indie moderna.">
    <meta name="keywords" content="Games, Indie, Plataform">
    <meta name="author" content="Matheus Laureano">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>DarkHydra</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/colors.css">
    <link rel="stylesheet" href="./css/painel.css">
</head>
<body>
    <br>
    <div class="container">
        <h1 class="display-4" style="color: #F0F0F0;"><i class="fa fa-terminal" aria-hidden="true"></i> Painel de Gestão</h1>
        <br><br>
        <div class="d-flex">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Fale Conosco</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Denuncias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Desenvolvedores</a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <br>
                <div class="row">
                    <div class="col">
                        <h1 class="titles"><i class="fa fa-eye-slash" aria-hidden="true"></i> Não Lidos</h1>
                        <div id="faleNao"></div>
                    </div>
                    <div class="col">
                        <h1 class="titles"><i class="fa fa-eye" aria-hidden="true"></i> Já Lidos</h1>
                        <div id="faleSim"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <br>
                <div class="row">
                    <div class="col">
                        <h1 class="titles"><i class="fa fa-eye-slash" aria-hidden="true"></i> Não Revisados</h1>
                        <div id="denunNao"></div>
                    </div>
                    <div class="col">
                        <h1 class="titles"><i class="fa fa-eye" aria-hidden="true"></i> Já Revisados</h1>
                        <div id="denunSim"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <br>
                <div class="row">
                    <div class="col">
                        <h1 class="titles"><i class="fa fa-eye-slash" aria-hidden="true"></i> Não Ativados</h1>
                        <div id="devNao"></div>
                    </div>
                    <div class="col">
                        <h1 class="titles"><i class="fa fa-eye" aria-hidden="true"></i> Já Ativados</h1>
                        <div id="devSim"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/fontawesome.js"></script>
    <script>
        const faleconoscoNew = document.getElementById('faleNao');
        const faleconoscoOld = document.getElementById('faleSim');
        let faleNew = "";
        let faleOld = "";
        const denunciasNew = document.getElementById('denunNao');
        const denunciasOld = document.getElementById('denunSim');
        let denuNew = "";
        let denuOld = "";
        const desenvolvedorNew = document.getElementById('devNao');
        const desenvolvedorOld = document.getElementById('devSim');
        let devNew = "";
        let devOld = "";

        $(() => {
            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "https://sleepy-river-60466.herokuapp.com/gestao/faleconosco/new",
                success: function(data){
                    for(var i = 0; i < data.length; i++) {
                        faleNew += '<div class="faleconosco bluebg">';
                        faleNew += '<form method="post" action="./php/faleconosco_visto.php">';
                        faleNew += '<input type="hidden" name="idThing" value="'+data[i]['idMensagem']+'">';
                        faleNew += '<span class="personitem" onclick="location.href = \'perfiljava.php?u='+data[i]['idPerfil']+'\'"><img src="'+data[i]['imagemPerfil']+'" width="50" height="50" style="display: inline; border-radius: 50%;">';
                        faleNew += '<span class="nomes"><span>'+data[i]['nomePerfil']+'</span><span> ('+data[i]['nomeUsuario']+')</span></span></span>';
                        faleNew += '<br>';
                        faleNew += '<h3 style="display: inline;">Email: </h3><h5 style="display: inline;">'+data[i]['emailUsuario']+'</h5>';
                        faleNew += '<br>';
                        faleNew += '<h3 style="display: inline;">Tópico: </h3><h5 style="display: inline;">'+data[i]['topico']+'</h5>';
                        faleNew += '<h3>Mensagem:</h3>';
                        faleNew += '<h5 class="wraptext">'+data[i]['mensagem']+'</h5>';
                        faleNew += '<div class="d-flex justify-content-end">';
                        faleNew += '<input type="submit" class="btn btn-primary" value="Marcar como Lido">';
                        faleNew += '</div>';
                        faleNew += '</form>';
                        faleNew += '</div>';
                    }
                    faleconoscoNew.innerHTML = faleNew;
                }
            });

            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "https://sleepy-river-60466.herokuapp.com/gestao/faleconosco/old",
                success: function(data){
                    for(var i = 0; i < data.length; i++) {
                        faleOld += '<div class="faleconosco bluebg">';
                        faleOld += '<form method="post" action="./php/faleconosco_naovisto.php">';
                        faleOld += '<input type="hidden" name="idThing" value="'+data[i]['idMensagem']+'">';
                        faleOld += '<span class="personitem" onclick="location.href = \'perfiljava.php?u='+data[i]['idPerfil']+'\'"><img src="'+data[i]['imagemPerfil']+'" width="50" height="50" style="display: inline; border-radius: 50%;">';
                        faleOld += '<span class="nomes"><span>'+data[i]['nomePerfil']+'</span><span> ('+data[i]['nomeUsuario']+')</span></span></span>';
                        faleOld += '<br>';
                        faleOld += '<h3 style="display: inline;">Email: </h3><h5 style="display: inline;">'+data[i]['emailUsuario']+'</h5>';
                        faleOld += '<br>';
                        faleOld += '<h3 style="display: inline;">Tópico: </h3><h5 style="display: inline;">'+data[i]['topico']+'</h5>';
                        faleOld += '<h3>Mensagem:</h3>';
                        faleOld += '<h5 class="wraptext">'+data[i]['mensagem']+'</h5>';
                        faleOld += '<div class="d-flex justify-content-end">';
                        faleOld += '<input type="submit" class="btn btn-warning" value="Marcar como não Lido">';
                        faleOld += '</div>';
                        faleOld += '</form>';
                        faleOld += '</div>';
                    }
                    faleconoscoOld.innerHTML = faleOld;
                }
            });

            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "https://sleepy-river-60466.herokuapp.com/gestao/denuncias/new",
                success: function(data){
                    for(var i = 0; i < data.length; i++) {
                        denuNew += '<div class="faleconosco bluebg">';
                        denuNew += '<form method="post" action="./php/denuncias_visto.php">';
                        denuNew += '<input type="hidden" name="idThing" value="'+data[i]['idDenuncia']+'">';
                        denuNew += '<span class="personitem" onclick="location.href = \'perfiljava.php?u='+data[i]['idDenunciante']+'\'"><span style="color: #4697F2;">Denunciante: </span><img src="'+data[i]['fotoDenunciante']+'" width="50" height="50" style="display: inline; border-radius: 50%;">';
                        denuNew += '<span class="nomes"><span>'+data[i]['nomeDenunciante']+'</span><span> ('+data[i]['userDenunciante']+')</span></span></span>';
                        denuNew += '<br><br>';
                        denuNew += '<span class="personitem" onclick="location.href = \'perfiljava.php?u='+data[i]['idDenunciado']+'\'"><span style="color: #F24646;">Denunciado: &nbsp</span><img src="'+data[i]['imagemDenunciado']+'" width="50" height="50" style="display: inline; border-radius: 50%;">';
                        denuNew += '<span class="nomes"><span>'+data[i]['nomeDenunciado']+'</span><span> ('+data[i]['userDenunciado']+')</span></span></span>';
                        denuNew += '<br>';
                        denuNew += '<h3 style="display: inline;">Tópico: </h3><h5 style="display: inline;">'+data[i]['topico']+'</h5>';
                        denuNew += '<h3>Mensagem:</h3>';
                        denuNew += '<h5 class="wraptext">'+data[i]['mensagem']+'</h5>';
                        denuNew += '<div class="d-flex justify-content-end">';
                        denuNew += '<input type="submit" class="btn btn-primary" value="Marcar como Lido">';
                        denuNew += '</div>';
                        denuNew += '</form>';
                        denuNew += '</div>';
                    }
                    denunciasNew.innerHTML = denuNew;
                }
            });

            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "https://sleepy-river-60466.herokuapp.com/gestao/denuncias/old",
                success: function(data){
                    for(var i = 0; i < data.length; i++) {
                        denuOld += '<div class="faleconosco bluebg">';
                        denuOld += '<form method="post" action="./php/denuncias_naovisto.php">';
                        denuOld += '<input type="hidden" name="idThing" value="'+data[i]['idDenuncia']+'">';
                        denuOld += '<span class="personitem" onclick="location.href = \'perfiljava.php?u='+data[i]['idDenunciante']+'\'"><span style="color: #4697F2;">Denunciante: </span><img src="'+data[i]['fotoDenunciante']+'" width="50" height="50" style="display: inline; border-radius: 50%;">';
                        denuOld += '<span class="nomes"><span>'+data[i]['nomeDenunciante']+'</span><span> ('+data[i]['userDenunciante']+')</span></span></span>';
                        denuOld += '<br><br>';
                        denuOld += '<span class="personitem" onclick="location.href = \'perfiljava.php?u='+data[i]['idDenunciado']+'\'"><span style="color: #F24646;">Denunciado: &nbsp</span><img src="'+data[i]['imagemDenunciado']+'" width="50" height="50" style="display: inline; border-radius: 50%;">';
                        denuOld += '<span class="nomes"><span>'+data[i]['nomeDenunciado']+'</span><span> ('+data[i]['userDenunciado']+')</span></span></span>';
                        denuOld += '<br>';
                        denuOld += '<h3 style="display: inline;">Tópico: </h3><h5 style="display: inline;">'+data[i]['topico']+'</h5>';
                        denuOld += '<h3>Mensagem:</h3>';
                        denuOld += '<h5 class="wraptext">'+data[i]['mensagem']+'</h5>';
                        denuOld += '<div class="d-flex justify-content-end">';
                        denuOld += '<input type="submit" class="btn btn-warning" value="Marcar como não Lido">';
                        denuOld += '</div>';
                        denuOld += '</form>';
                        denuOld += '</div>';
                    }
                    denunciasOld.innerHTML = denuOld;
                }
            });

            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "https://sleepy-river-60466.herokuapp.com/gestao/devs/new",
                success: function(data){
                    for(var i = 0; i < data.length; i++) {
                        devNew += '<div class="faleconosco bluebg">';
                        devNew += '<form method="post" action="./php/desenvolvedor_visto.php">';
                        devNew += '<input type="hidden" name="idThing" value="'+data[i]['idUsuario']+'">';
                        devNew += '<h3 style="display: inline;">Id de usuário: </h3><h5 style="display: inline;">'+data[i]['idUsuario']+'</h5>';
                        devNew += '<br>';
                        devNew += '<h3 style="display: inline;">Nome de Usuário: </h3><h5 style="display: inline;">'+data[i]['nomeUsuario']+'</h5>';
                        devNew += '<br>';
                        devNew += '<h3 style="display: inline;">Razão Social: </h3><h5 style="display: inline;">'+data[i]['razaoSocial']+'</h5>';
                        devNew += '<br>';
                        devNew += '<h3 style="display: inline;">Email: </h3><h5 style="display: inline;">'+data[i]['emailUsuario']+'</h5>';
                        devNew += '<br>';
                        devNew += '<h3 style="display: inline;">CNPJ: </h3><h5 style="display: inline;">'+data[i]['cnpj']+'</h5>';
                        devNew += '<div class="d-flex justify-content-end">';
                        devNew += '<input type="submit" class="btn btn-primary" value="Ativar">';
                        devNew += '</div>';
                        devNew += '</form>';
                        devNew += '</div>'
                    }
                    desenvolvedorNew.innerHTML = devNew;
                }
            });

            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "https://sleepy-river-60466.herokuapp.com/gestao/devs/old",
                success: function(data){
                    for(var i = 0; i < data.length; i++) {
                        devOld += '<div class="faleconosco bluebg">';
                        devOld += '<form method="post" action="./php/desenvolvedor_naovisto.php">';
                        devOld += '<input type="hidden" name="idThing" value="'+data[i]['idUsuario']+'">';
                        devOld += '<h3 style="display: inline;">Id de usuário: </h3><h5 style="display: inline;">'+data[i]['idUsuario']+'</h5>';
                        devOld += '<br>';
                        devOld += '<h3 style="display: inline;">Nome de Usuário: </h3><h5 style="display: inline;">'+data[i]['nomeUsuario']+'</h5>';
                        devOld += '<br>';
                        devOld += '<h3 style="display: inline;">Razão Social: </h3><h5 style="display: inline;">'+data[i]['razaoSocial']+'</h5>';
                        devOld += '<br>';
                        devOld += '<h3 style="display: inline;">Email: </h3><h5 style="display: inline;">'+data[i]['emailUsuario']+'</h5>';
                        devOld += '<br>';
                        devOld += '<h3 style="display: inline;">CNPJ: </h3><h5 style="display: inline;">'+data[i]['cnpj']+'</h5>';
                        devOld += '<div class="d-flex justify-content-end">';
                        devOld += '<input type="submit" class="btn btn-warning" value="Desativar">';
                        devOld += '</div>';
                        devOld += '</form>';
                        devOld += '</div>'
                    }
                    desenvolvedorOld.innerHTML = devOld;
                }
            });
        });
    </script>
    <br><br><br>
</body>
</html>