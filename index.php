<?php 
require 'bdd.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des tâches</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main">
       <div class="ajouter">
          <form action="actions/ajouter.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input 
                    type="text" 
                    name="titre" 
                    placeholder="Remplis ta tâche ! >:)" 
                    style="border-color: #ff6666"/>
              <button type="submit">Ajouter</button>
             <?php }else{ ?>
              <input type="text" 
                     name="titre" 
                     placeholder="Remplis ta tâche :)" />
              <button type="submit">Ajouter</button>
             <?php } ?>
          </form>
       </div>
       <?php 
          $taches = $conn->query("SELECT * FROM taches ORDER BY id DESC");
       ?>
       <div class="liste-des-taches">
            <?php if($taches->rowCount() <= 0){ ?>
                <div class="tache-item">
                    <div class="empty">
                    </div>
                </div>
            <?php } ?>
            <?php while($tache = $taches->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="tache-item">
                    <span id="<?php echo $tache['id']; ?>"
                          class="supprimer">x</span>
                    <?php if($tache['finie']){ ?> 
                        <input type="checkbox"
                               class="finir"
                               data-tache-id ="<?php echo $tache['id']; ?>"
                               finie />
                        <h2 class="finie"><?php echo $tache['titre'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-tache-id ="<?php echo $tache['id']; ?>"
                               class="finir" />
                        <h2><?php echo $tache['titre'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>créée: <?php echo $tache['date'] ?></small> 
                </div>
            <?php } ?>
       </div>
    </div>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.supprimer').click(function(){
                const id = $(this).attr('id');
                $.post("actions/supprimer.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });
            $(".finir").click(function(e){
                const id = $(this).attr('data-tache-id');
                $.post('actions/finir.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('finie');
                              }else {
                                  h2.addClass('finie');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>