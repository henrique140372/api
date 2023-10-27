<div class="footer text-center">

    <?php if(! empty( footer_txt_content() ) && empty(  lang('Footer.notice') )) : ?>
    <div class="footer-notice  text-muted p-20 pb-0 ">
        <?= esc( footer_txt_content() )  ?>
    </div>
    <?php endif; ?>

    <?php if(! empty( lang('Footer.notice') )) : ?>
        <div class="footer-notice  text-muted p-20 pb-0">
            <?= lang('Footer.notice') ?>
        </div>
    <?php endif; ?>

    <?php $links = get_footer_links();
          if(! empty($links)) : ?>
    <div class="footer-menu mt-20">
        <?php foreach ($links as $link) {
            echo anchor( $link['url'], $link['title'], [
                    'class' => 'text-muted d-inline-block mx-10'
            ]);
        } ?>
    </div>
    <?php endif; ?>

    <div class="copyright py-20">
       <?= ! empty( lang('Footer.copyright') ) ? lang('COPYRIGHT © 2023 TODOS DIREITOS RESERVADOS AOSEUGOSTO') :  esc( site_copyright() ) ?>
    </div>
    <!-- Início do código Chaport Live Chat -->
 <script type="text/javascript">
(function(w,d,v3){
w.chaportConfig = {
  appId : '64d68eb03ea225ed209e5ace'
};

if(w.chaport)return;v3=w.chaport={};v3._q=[];v3._l={};v3.q=function(){v3._q.push(arguments)};v3.on=function(e,fn){if(!v3._l[e])v3._l[e]=[];v3._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);
</script>
<!-- Fim do código do Chaport Live Chat -->
</div>