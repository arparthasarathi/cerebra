<div class="col-lg-2">
    <div class="row">
		<? if($sponsors) { ?>
		<div class="panel-group" id="accordion" name="k-accordian-subnavigation">
			<?php foreach($sponsors as $sponsor) : ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                        <a class="accordion-toggle" href="<? echo base_url().$system_type."/".$sponsor['sponsor_year']; ?>" data-pjax="true">
                            Kurukshetra <? echo strtoupper($sponsor['sponsor_year']); ?>
                        </a>
                        </div>
                    </div>
                </div>
            <? endforeach ?>
        </div>
        <? } ?>
    </div>
</div>
