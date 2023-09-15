 <div class="main-top my-shadow">
    <div class="main-bottom-title"><?=$title?></div>
    <div class="clock" style="font-weight: bold; letter-spacing: 1px;">
        <span><i class="fas fa-calendar-alt me-2 text-primary"></i></span>
        <span id="clock"></span>
    </div>
    <div class="main-top-right">
        <div class="main-profile">
            <img src="../../assets/images/admin-icon.jpg" alt="" class="main-profile-img shadow-4">
            <div class="ms-2">
            <div class="main-profile-name"><?=$userInfo['firstName'].' '. $userInfo['lastName']?></div>
            <div class="main-profile-role"><?=$userInfo['description']?></div>
            </div>
        </div>
        <div class="notification-container">
            <div id="pop" class="main-notification d-none">
                <?php if($show){?>
               <div class="d-block"><a href="<?=$link?>"><i class="fas fa-bell text-warning me-2"></i> You have <span class="fw-bold text-primary">( <?=$notifications?> )</span> Pending Requests</a>
               <div class="mt-1" style="font-weight: 600;"><?=$ago;?></div>
              </div>
               <?php }else{?>
                 <div class="p-1 shadow-1 rounded bg-light fst-italic"><span >You have no Pending Requests</span></div>
               <?php }?>
            </div>
            <a class="notifications" onclick="toggler()">
                <i class="fas fa-bell me-1"></i>Notifications
                <?php if($show){?>
                <span class="notif-count fw-bold text-primary">(<?=$notifications?>)</span> 
                <?php }?>
            </a>

        </div>
        <form action="" method="post">
            <div class="main-profile-logout"><button class="log-out-btn" name="logout" type="submit">Logout<i class="ms-2 fas fa-sign-out-alt"></i></button>
        </form>
    </div>
</div>

<script>
    var pop = document.querySelector('#pop');
    


    function toggler(){
        pop.classList.toggle('d-none')
    }

    var clock = document.querySelector('#clock');
    setInterval(()=>{
        const time = 
       clock.innerText = new Date().toString().slice(0,25);
    },1000)
    
</script>