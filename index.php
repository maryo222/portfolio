<?php 
    require 'partials/header.php';
    require 'partials/navigation.php';
    require 'includes/config.php';     
?>

        <!-- Start of Content -->
        <div class="container">
            <div class="row">
            <!-- Your loop will start here and loop through the card markup -->
                <?php
                foreach ($projects as $project):
                ?>
                <!-- Start of Card -->
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading card-header">
                        <img class="img-responsive" src="<?= $project['image_url'] ?>">
                        </div>

                        <div class="panel-body">
                            <h4><?= $project['title'] ?></h4>
                            <p><?= $project['content'] ?></p>
                            <a href="<?= $project['link'] ?>" class="btn btn-default btn-xs">View</a>
                            
                            <form action="partials/delete.php?id=<?php echo $project['id']; ?>" method="POST">
                            <button class="btn btn-default btn-xs" onclick="return confirm('are you sure you want to delete this item');">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Card -->

                <?php 
                    endforeach
                ?>

            </div>
        </div>

<?php 
    require 'partials/footer.php';
?>
