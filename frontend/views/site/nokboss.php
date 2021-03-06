<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Asos;
use frontend\models\AsosSlave;
use frontend\models\User;
use kartik\date\DatePicker;
use frontend\models\Haridor;
$this->title="Chek";
$date = date('Y-m-d');
?>
<div class="client-qarz">
    <div class="row">
        <?php ActiveForm::begin()?>
        <div class="col-md-3 client-qarz__date">
            <?php echo DatePicker::widget([
                'name' => 'date1',
                'value' => Yii::$app->request->post('date1')?Yii::$app->request->post('date1'):date('Y-m-d'),
                'options' => ['placeholder' => 'Sanani tanlang...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>

        <div class="col-md-1 client-qarz__button">
            <button type="submit" class="btn btn-primary">Qidirish</button>
        </div>
        <?php ActiveForm::end()?>
    </div>
</div>
<div  style="text-align: center;margin: 2px; background-color: rgba(43,106,246,0.77);">
<table class="table table-bordered" id="users">
<tr><th>Стол</th><th>Чек №</th><th>Сана</th><th>Жами<br>сум, %</th></tr>
<?php
$i = 0;$summa = 0;$summaJami = 0;
foreach ($s as $item):
?>
<tr style="background-color:#B6E8F8;" id="<?=$item['id'];?>" class="chekqator-<?=$item['id'];?>">
  <td>
        <input type="text" value="<?=$item->id?>" name="asosid" hidden>
        <input type="text" value="<?=$item->diler_id?>" name="dilerid" hidden>
           <?php
           $i++;$summa = $summa + $item['summa'];
           //$summaJami = $summaJami + $item['summa_ch'];
           $nom = \frontend\models\SMobil::find()->where(['id'=>$item->mobil])->one();

           $user = user::find()->where(['id'=>$item->user_id])->one();?>

           <?=$nom['nom']?><br><?=$user['username']?>
  </td>
  <td>
    <input type="text" value="<?=$nom->nom?>" name="stol" hidden>
     <input type="text" value="<?=$item->summa_ch?>" name="summa_ch" hidden>
    <?=$item['diler_id']?><br>
    <?php
           echo "<img id = 'img".$item['id']."' src=\"/images/down.png\" border=\"0\" style=\"cursor:pointer\" onclick=\"do_ajax_fnc(this,$item[id],$item[id],'divlk$item[id]')\"/>";
           ?>
  </td>
  <td>
    <?=$item['changedate']?>
  </td>
    <?php
  	$ss = AsosSlave::find()->where(['del_flag'=>1])->where('asos_id='.$item['id'])->all();
	$kol=0;$summa_all=0;
	foreach ($ss as $tem) {
		$kol=$kol+$tem['kol'];$summa_all=$summa_all+$tem['summa_all'];
	}
	$summa_all = $summa_all	+ $summa_all*$item['xizmat_foiz']/100;
    $summa_all = round($summa_all,-2);
	$summaJami = $summaJami + $summa_all;
  ?>
  <td><span class="sum<?=$item[id]?>">

  <?=$summa_all?></span><br><?=$item['xizmat_foiz']?> %</td>

</tr>
<tr><td colspan=11>
<div id="divlk<?=$item[id]?>" style="visibility:hidden;display:none;background-color:#B6E8F8 ;">
<table class="mb-0 table table-hover">
	<tr id="<?=$item[id]?>">
        <td><a class="npb" href="#">Naqd</a></td><td><span class="ntxt<?=$item[id]?>"><?=$item['sum_naqd_ch']?></span></td>
        <td><input type="number" name="np" value="" class="nkirit<?=$item[id]?>"></td>
    </tr>
    <tr id="<?=$item[id]?>" >
        <td><a class="npb" href="#">Plastik</a></td><td><span class="ptxt<?=$item[id]?>"><?=$item['sum_plast_ch']?></span></td>
        <td><input type="number" name="hp" value="" class="pkirit<?=$item[id]?>"></td>
    </tr>
    <tr id="<?=$item[id]?>">
        <td><a class="npb" href="#">Bank</a></td><td><span class="btxt<?=$item[id]?>"><?=$item['sum_epos_ch']?></span></td>
        <td><input type="number" name="he" value="" class="bkirit<?=$item[id]?>"></td>
    </tr>
    <tr id="<?=$item[id]?>">
        <td><button class="btn btn-success">Saqlash</button></td><td></td>
        <td><i class="fa fa-refresh"  style="font-size:32px;color:red"></i></td>
    </tr>
    <tr id="<?=$item[id]?>">
        <td>Mijoz <i class = "fa fa-plus"></i> <?php echo "<img id = 'img".$item['id']."' src=\"/images/down.png\" border=\"0\" style=\"cursor:pointer\" onclick=\"do_ajax_fnc(this,$item[id],$item[id],'divmijoz$item[id]')\"/>"?>;
           </td>
        <td class="har<?=$item[id]?>" colspan="4">
        <?php
        echo \kartik\select2\Select2::widget([
            'name' => 'haridor','id' => 'haridor',
            'data' => $haridorlar,
            'value'=>$item['h_id'],
            'options' => ['placeholder' => 'Haridor nomi...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])

        ?>
 </select>
 </td>
 <tr id="<?=$item[id]?>">
 <td colspan="4">
  <div id="divmijoz<?=$item[id]?>" style="visibility:hidden;display:none;background-color:#B6E8F8 ;">
   Nomi:<input type="text" name="mnomi" value="" class="fio<?=$item[id]?>" >
    Tel:<input type="number" name="telnomer" value="" class="tel<?=$item[id]?>" >
    <button id="qosh" class="btn btn-success">Qo'shish</button>
   </div>
</td>
</tr>
    </tr>
    <tr id="<?=$item[id]?>">
        <td><a class="npb" href="#">Qarz</a></td><td><span class="qtxt<?=$item[id]?>"><?=$item['qarz_summa']?></span></td>
        <td><input type="number" name="np" value="" class="qkirit<?=$item[id]?>"></td>
    </tr>
    <tr><td><div class="mq<?=$item[id]?>"></div></td></tr>

</table>
<table class="table table-bordered">
	<tr><td>Nomi</td><td>Soni</td><td>Narxi</td><td>Summasi</td><tr>
<?php foreach ($ss as $so){?>
	<tr>
        <td><?= $so['tovar_nom']?></td>
        <td><?= $so['kol']?></td>
        <td><?= $so['sotish']?></td>
        <td><?= $so['summa_all']?></td>
	</tr>
<?php }?>
</table>
</div>
</td></tr>

<?php //echo "<tr><td colspan=\"11\"><div id=\"divlk$item[id]\" style=\"visibility:hidden;display:none;background-color:#B6E8F8 ;\"></div></td></tr>";
?>

<?php endforeach;?>
<th>Жами</th><th><?=$i?></th><th></th><th><?=$summaJami?></th>
</table>
</div>
<script type="text/javascript">
$('#haridor').on('change', function(e){
    $haridor=$('#haridor').val();
    jid=$(this).parent().parent().attr('id');
    $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/site/mijozchange'?>',
        type: 'POST',
        data: {jid:jid,haridor:$haridor},
        success: function(data){
            
        },
        error: function(){
          alert("xatolik yuz berdi !!!");
        }
    });
});
$('#qosh').on('click', function(e){
    e.preventDefault();
    jid=$(this).parent().parent().parent().attr('id');  // jid=455
    $fio=$(".fio"+jid).val(); // $nkirit=$(".nkirit455").val();nkirit  узгарувчига унг томондаги киймат узатилади.
     //   тестни сонга айлантириш
    $tel=$(".tel"+jid).val();

    if($fio==''){alert('Haridor nomi kiritilmagan !!!');exit;}
    if($tel==''){alert('Haridor telefon raqami kiritilmagan !!!');exit;}

    $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/site/mijozqosh'?>',
        type: 'POST',
        data: {jid:jid,fio:$fio,tel:$tel},
        success: function(data){
            $(".har"+jid).html($fio+" "+$tel);
           // do_ajax_fnc("img19",mid,flag,"divmijoz19",och);
        },
        error: function(){
          alert("Xatolik yuz berdi !!!");
        }
    });
});
$('.fa-refresh').on('click', function(e){
    e.preventDefault();
    jid=$(this).parent().parent().attr('id');$summa=+$(".sum"+jid).html();  // jid=455
    $nkirit=$(".nkirit"+jid).val(); // $nkirit=$(".nkirit455").val();nkirit  узгарувчига унг томондаги киймат узатилади.
    nkirit=+$nkirit; //   тестни сонга айлантириш
    $pkirit=+$(".pkirit"+jid).val();$bkirit=+$(".bkirit"+jid).val();
    $qkirit=+$(".qkirit"+jid).val();

    if($nkirit+$pkirit+$bkirit+$qkirit==''){alert('Summa kiritilmagan');exit;}
    if($nkirit+$pkirit+$bkirit>$summa){alert('Summa no`to`gri');exit;}
    if($bkirit>0 && $nkirit+$pkirit+$bkirit!=$summa){alert('Summa teng emas');exit;}

    $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/site/nokboss'?>',
        type: 'POST',
        data: {oper:"taqsimlash",jid:jid,summa:$summa,nkirit:$nkirit,pkirit:$pkirit,bkirit:$bkirit,qkirit:$qkirit},
        success: function(data){
            if($bkirit>0){
                $('.btxt'+jid).text($bkirit);$('.ntxt'+jid).text($nkirit);$('.ptxt'+jid).text($pkirit);
                $('.nkirit'+jid).val('');$('.pkirit'+jid).val('');$('.bkirit'+jid).val('');
                return true;
            }
            if($nkirit>0){
                $('.ntxt'+jid).text($nkirit);$('.ptxt'+jid).text($summa-$nkirit);$('.btxt'+jid).text('');
                $('.nkirit'+jid).val('');$('.pkirit'+jid).val('');$('.bkirit'+jid).val('');
                return true;
            }
            if($pkirit>0){
                $('.ptxt'+jid).text($pkirit);$('.ntxt'+jid).text($summa-$pkirit);$('.btxt'+jid).text('');
                $('.nkirit'+jid).val('');$('.pkirit'+jid).val('');$('.bkirit'+jid).val('');
                return true;
            }

            if($qkirit!=0){
                if($qkirit>0)
                {
                    $('.qtxt'+jid).text($qkirit);
                }
                else
                {
                    //alert($qkirit);

                    $('.qtxt'+jid).text($summa+$qkirit);
                }

                $('.qkirit'+jid).val('');
            }


            //alert($bu);
        }
        ,error: function(){
            alert("xatolik yuz berdi !!!");
        }
    });
});
$('.npb').on('click', function(e){
    e.preventDefault();
    jid=$(this).parent().parent().attr('id'); //15
    $summa=+$(".sum"+jid).html();$qarz=+$(".qtxt"+jid).html();
    $bu=($(this).html());

    $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/site/nokboss' ?>',
        type: 'POST',
        data: {oper:$bu,jid:jid,summa:$(".sum"+jid).html(),qtxt:$qarz},
        success:
         function(data){
            if($bu==="Qarz"){
                if( $qarz == 0 )
                {
                    $('.qtxt'+jid).text($summa);
                }
                else
                {
                    $('.qtxt'+jid).text('0');
                }
            }
            if($bu==="Naqd"){
                $('.ntxt'+jid).text($(".sum"+jid).html());$('.ptxt'+jid).text('');$('.btxt'+jid).text('');
            }

            if($bu==="Plastik"){
                $('.ptxt'+jid).text($(".sum"+jid).html());$('.ntxt'+jid).text('');$('.btxt'+jid).text('');
            }
            if($bu==="Bank"){
                $('.btxt'+jid).text($(".sum"+jid).html());$('.ntxt'+jid).text('');$('.ptxt'+jid).text('');
            }

            //alert($bu)
        }

        ,error: function(){
            alert("xatolik yuz berdi !!!");
        }
    });
});
function do_ajax_fnc(img,mid,flag,divname,och){
    divel = document.getElementById(divname);
    //if (!divel){return;}
    if (divel.style.visibility == 'visible') {
        divel.style.visibility = 'hidden';
        divel.style.display = 'none';
        img.src = '/images/down.png';
    } else {
        divel.style.visibility = 'visible';
        divel.style.display = 'block';
        img.src = '/images/up.png';
    }
    if (och == 'N') {
        divel.style.visibility = 'hidden';
        divel.style.display = 'none';
        img.src = '/images/down.png';
    }
    if (och == 'Y') {
        divel.style.visibility = 'visible';
        divel.style.display = 'block';
        img.src = '/images/up.png';
    }

}
</script>