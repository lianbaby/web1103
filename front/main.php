<style>
#poster{
  width: 420px;
  height: 400px;
  position: relative;
}
.lists{
  width: 210px;
  height: 280px;
  position: relative;
  margin: auto; /*海報維持在正中間 */
  overflow: hidden;
}

.pos{
 width: 210px; 
 height: 280px;
 position: absolute;
 text-align: center;
 display: none;
}

.pos img{
  width: 100%;
  height: 260px;
}

.controls{
  width: 420px;
  height: 110px;
  margin: 10px auto 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  position: absolute;
  bottom: 0;
}

.left,.right{
  /* transparent透明色 */
  border-top:20px solid transparent ;
  border-bottom:20px solid transparent ;
}

.left{
  border-right:20px solid black ;
}

.right{
  border-left:20px solid black;
}
.btns{
  width: 320px;
  height: 100px;
  display: flex;
  overflow: hidden;/*hidden超出範圍的部份*/
}

.btn{
  width: 80px;
  font-size: 12px;
  text-align:center;
  flex-shrink: 0;/*保持設定的寬度，不要跑掉 */
  box-sizing: border-box;
  position: relative; /*一定要有定位點，否則不能滑動 */
  padding:3px;
}
.btn img{
  width: 100%;
  height: 80px;
}


</style>
<div class="half" style="vertical-align:top;">
      <h1>預告片介紹</h1>
      <div class="rb tab" style="width:95%;">
        <div id="poster">
          <div class="lists">
            <?php
              $posters=$Trailer->all(['sh'=>1]," order by rank");
              foreach($posters as $poster){
            ?>
            <div class="pos" data-ani="<?=$poster['ani'];?>">
              <img src="./upload/<?=$poster['img'];?>" alt="">
              <div><?=$poster['name'];?></div>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="controls">
            <div class="left"></div>
            <div class="btns">
            <?php
              foreach($posters as $poster){
            ?>
              <div class="btn">
                <img src="./upload/<?=$poster['img'];?>" alt="">
                <div><?=$poster['name'];?></div>
              </div>
              <?php
              }
              ?>
            </div>
            <div class="right"></div>
          </div>
        </div>
      </div>
    </div>

    <script> 
      $(".pos").eq(0).show(); //只秀出第一張海報

      let btns=$(".btn").length;
      let p=0;
      $(".right,.left").on("click",function(){
        if($(this).hasClass('left')){
          p=(p - 1 >= 0)? p-1 : p;
        }else{
          p=(p + 1 <= btns - 4)? p+1 : p;
        }
        $(".btn").animate({right:80*p});
      })
      
      
      
      
      let now=0;
      let counter=setInterval(()=>{
          ani();
        },3000);

        $(".btn").on("click",function(){
          let _this=$(this).index();
          //console.log(now+1,_this);
          ani(_this);

        })


      function ani(next){
        now=$(".pos:visible").index();
        if(typeof(next)=='undefined'){
          next=(now+1<=$(".pos").length-1)?now+1:0;
          }

        let AniType=$('.pos').eq(next).data('ani');
        switch(AniType){
          case 1:
              $(".pos").eq(now).fadeOut(1000,()=>{
                $(".pos").eq(next).fadeIn(1000);
              });
          break;
          case 2:
              $(".pos").eq(now).hide(1000,()=>{
                $(".pos").eq(next).show(1000);
              });
          break;
          case 3:
              $(".pos").eq(now).slideUp(1000,()=>{
                $(".pos").eq(next).slideDown(1000);
              });
          break;
        }
      }
      

      $(".btns").hover(
        function (){
          clearInterval(counter);
        },
        function(){
          counter=setInterval(()=>{
            ani();
          },3000)
        }
      )
    </script>

    <div class="half">
      <h1>院線片清單</h1>
      <div class="rb tab" style="width:95%;">
      <!-- display:flex橫排，wrap自動換行 -->
        <div style="display:flex;flex-wrap:wrap"> 
          <?php
            $today=date("Y-m-d");
            $ondate=date("Y-m-d",strtotime(("-2 days")));
            $all=$Movie->count(" where `sh`=1 && `ondate` between '$ondate' AND '$today'");
            $div=4;
            $pages=ceil($all/$div);
            $now=$_GET['p']??1;
            $start=($now-1)*$div;
            $rows=$Movie->all(['sh'=>1]," && `ondate` between '$ondate' AND '$today' order by `rank` limit $start,$div");

            foreach($rows as $row){

          ?>
            <div style="width:45%;margin:0.5%;border:1px solid white;border-radius:5px;padding:5px">
              <div>片名：<?=$row['name'];?></div>
              <div style="display:flex">
                
                <div>
                  <a href="#" onclick="location.href='?do=intro&id=<?=$row['id'];?>'">
                    <img src="./upload/<?=$row['poster'];?>" style="width: 60px;height:80px" >
                  </a>
                </div>
                
                <div>
                    <p>分級：<img src="./icon/03C0<?=$row['level'];?>.png" alt=""></p>
                    <p>上映日期：<?=$row['ondate'];?></p>
                </div>

              </div>
              <div>
                <button onclick="location.href='?do=intro&id=<?=$row['id'];?>'">劇情簡介</button>
                <button onclick="location.href='?do=order&id=<?=$row['id'];?>'">線上訂票</button>
              </div>
              
              
              
            </div>
          <?php
          }
          ?>


        </div>
        <div class="ct">
          <?php
            for($i=1;$i<=$pages;$i++){
              $size=($i==$now)?'20px':'16px';
              echo "<a href='index.php?p=$i' style='font-size:$size'>";
              echo $i;
              echo " </a>";
            }
      
      
          ?>
        </div>
      </div>
    </div>