<!-- css is on request.css -->
<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');

 $items = getAllNonConsumableItems($conn);
 $categories = nonConsumableCategories($conn);

 
if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];
 
?>

<div class="main-form-request mt-5">
   <div class="main-form-left  me-4">
     <div class="form-group form-group-select">
        <label>By Categories</label>
        <input type="hidden" name="" id="currentUser" value="<?=$userInfo['id']?>">
        <input type="hidden" name="" id="currentRole" value="<?=$userInfo['role']?>">
        <input type="hidden" name="" id="currentType" value="2">
        <select id="catFilter" onchange="setter(this)" required  name="itemId" class="form-control">
            <option value="0" selected>All Categories</option>
            <?php
                while($category = $categories->fetch_assoc()){
               
            ?>
            <option  value="<?=$category['cat_id'];?>"><?=$category['categ_description'];?></option>
            <?php } ?>
        </select>
        </div>
       <div class="main-form-left-input">
          <label>Item</label>
           <div class="form-group">
              <input type="hidden" id="itemId" value="0">
              <input autocomplete="off" id="searchInput" onfocusout='hideResult()' onfocus="searchItem(this)"  onkeyup="searchItem(this)" placeholder="Select/Search" type="text" class="form-control">
           </div>
           <div id="result" class="search-results">
               <ul id="consumableResult">
                
               </ul>
           </div>
       </div>
       <div class="main-form-left-input">
            <label>Quantity (Maximum : <span id="maxQty"></span>)</label>
           <div class="form-group">
              <input id="qty"  min='1' pattern='[0-9]' step='1' placeholder="Qty" type="Number" class="form-control">
           </div>
       </div>
       <div class="form-group">
          <button onclick="addOnQueue()" class="btn btn-primary btn-block">Add <i class="fas fa-plus ms-1"></i></button>
       </div>
   </div>
   <div class="main-form-right" id="listDisplay">

   </div>
</div>

<script>

    var listLoader = () =>{
        $('#listDisplay').load('../../ajax/nonList.table.php')
    }
    
    listLoader();


    var filter = document.querySelector('#catFilter');
    var max = 0;

    var setSelected = (id,description,maximum)=>{
       
        max = maximum;
        document.querySelector('#maxQty').innerHTML = maximum
        document.querySelector('#itemId').value = id;
        document.querySelector('#result').style = 'display:none'
        document.querySelector('#searchInput').value= description.innerHTML
        hideResult()

    }
    
    var setter = (element)=>{
         document.querySelector('#searchInput').value= ''
         document.querySelector('#itemId').value = 0;
        // console.log(element.options[element.selectedIndex].innerText)
    }

    var hideResult = (text)=>{
        setTimeout(()=>{
            document.querySelector('#result').style = 'display:none'

        },500)
    }

    var searchItem = (element)=>{
            document.querySelector('#itemId').value = 0;
            $.post('../../ajax/searchContents.php',{
                type: 2,
                key: element.value,
                filter: filter.value
            }).then(result=>{
                document.querySelector('#consumableResult').innerHTML = result;
                document.querySelector('#result').style = 'display:block'
            })
    }

    var clearList = ()=>{
        document.querySelector('#itemId').value = 0;
        document.querySelector('#result').style = 'display:none'
        document.querySelector('#searchInput').value= ''
    }

    var addOnQueue = ()=>{
        if(document.querySelector('#itemId').value === '0'){
             document.querySelector('#searchInput').value= ''
             document.querySelector('#searchInput').focus()
             Swal.fire(
            '',
            'Invalid Item Description',
            'question'
        )
         document.querySelector('#consumableResult').focus
         return;

        }
        if(document.querySelector('#qty').value < 1){
           
             Swal.fire(
            '',
            'Please Enter a Valid Quantity',
            'info'
             )
          return
        }

        const owner = document.querySelector('#currentUser').value;
        const itemType = document.querySelector('#currentType').value;
        const item = document.querySelector('#itemId').value
        const itemQuantity = document.querySelector('#qty').value
        // console.log('owner'+owner)
        // console.log('itemType'+itemType)
        // console.log('item'+item)
        // console.log('itemQuantity'+owner)
      
        // catch on request.controller.php add list
        $.post('../../ajax/addQueue.php',{
            owner,
            itemType,
            item,
            itemQuantity
        }).then(result=>{
           const res = JSON.parse(result);

           if(res.added){
             Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Added on Queue',
                showConfirmButton: false,
                timer: 1000
                })
             listLoader();
           }else{
             Swal.fire(
            '',
            "Can't add, Maximum Quantity Exceeded",
            'warning'
             )
           }
           
           document.querySelector('#searchInput').value= ''
           document.querySelector('#qty').value = ''


        })
    }

    document.querySelector('#qty').addEventListener('keyup',(e)=>{
        if(e.keyCode === 189 || e.keyCode === 190 || e.keyCode === 69){
          document.querySelector('#qty').value = ''
        }
       
    })

    var deleteList = (id)=>{
        Swal.fire({
        title: 'Are you sure?',
        text: "Item will be removed!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
        }).then((result) => {
        if (result.isConfirmed) {
            $.post('../../ajax/deleteList.php',{
                deleteId: id
            }).then(ok=>{
                listLoader()
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Item Removed',
                showConfirmButton: false,
                timer: 1500
                })
            })
        }
    })
    }

    var submitRequest = ()=>{
        const totalItems = document.querySelector('#itemCounter').value;
        const owner = document.querySelector('#currentUser').value;
        const itemType = document.querySelector('#currentType').value;
        const currentRole = document.querySelector('#currentRole').value;
       
       

        if(totalItems > 0){
             Swal.fire({
                title: 'Please Confirm?',
                text: "Submit Request?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post('../../ajax/addRequest.php',{
                        itemCount : totalItems,
                        owner,
                        itemType,
                        currentRole
                    }).then(res=>{
                        console.log(res)
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Request Sent!',
                        showConfirmButton: false,
                        timer: 1500
                        })
                        listLoader()
                    })
                }
            })
           
        }
    }

    
</script>