<div class="col-lg-2">
    <div class="row">
		<? if($accordionmenu) { ?>
		<div class="panel-group" id="accordion" name="k-accordian-subnavigation">
			<?php foreach($accordionmenu as $a) : ?>
                <div class="panel panel-default">
                    <div  class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle" href="<? echo base_url().$system_type."/".$a['xceed_url']; ?>" data-pjax="true">
                                <? echo strtoupper($a['xceed_title']); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <? endforeach ?>
        </div>
        <? } ?>
    </div>
</div>
