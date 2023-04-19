<?php

require_once(BASE_PATH.'/template/admin/layout/header.php');

?>

<section class="pt-3 pb-1 mb-2 border-bottom">
    <h1 class="h5">Create Category</h1>
</section>
<section class="row my-3">
    <section class="col-12">
        <form method="post" action="<?= url('admin/category/store') ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name ...">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">store</button>
        </form>
    </section>
</section>

    </main>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/mdb.min.js"></script>

    </body>

    </html>

    <?php
    require_once(BASE_PATH . '/template/admin/layout/footer.php');

    ?>
