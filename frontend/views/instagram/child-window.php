<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 13.05.17
 * Time: 9:52
 */

/**
 * @var $errors array
 * */
?>


<script>
    //as string into JavaScript
    window.instaErrors = '<?=(!empty($errors))
        ? json_encode($errors)
        : ''?>';
    window.instaProfile = '<?=(!empty($profile))
        ? json_encode($profile)
        : ''?>';
    window.close();
</script>
