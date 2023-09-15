<script>
     const mainCategories = document.querySelectorAll('.main-category-type');
     const parForm = document.querySelector('#parFormQty');
     const parEditForm = document.querySelector('#parEditFormQty');
     const parItemQty = document.querySelector('#parItemQty');
     const parEditItemQty = document.querySelector('#parEditItemQty');
     const modalCloser = document.querySelector('#modalCloser');
     const modalEditCloser = document.querySelector('#modalEditCloser');
     const distributions = document.querySelectorAll('.distributions');


     let parId = 0;
   
     

     parForm.addEventListener('submit',(e)=>{
         e.preventDefault()
        let total = 0;
        let jan = distributions[0].value;
        let feb = distributions[1].value;
        let mar = distributions[2].value;
        let apr = distributions[3].value;
        let may = distributions[4].value;
        let june = distributions[5].value;
        let july = distributions[6].value;
        let aug = distributions[7].value;
        let sep = distributions[8].value;
        let oct = distributions[9].value;
        let nov = distributions[10].value;
        let dec = distributions[11].value;

         distributions.forEach(dis=>{
            total += Number(dis.value);
         })

         parItemQty.value = total;
       
         if(parItemQty.value < 1){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You Need to Include at least 1!',
            })
         }else{
            addParItem(parId,parItemQty.value,jan,feb,mar,apr,may,june,july,aug,sep,oct,nov,dec)
            distributions.forEach(dis=>{
                dis.value = 0
            })
            parItemQty.value = 0;
         }
     })

     parEditForm.addEventListener('submit',(e)=>{
         e.preventDefault()
        submitEditPar(parId,parEditItemQty.value)
         
     })

    

    const toggleActive = (element)=>{
        if(element.id == 'allItem'){
            loadAll()
        }else{
            loadUnAdded()
        }
        if(element.id == 'stats'){

        }
        resetSelection()
        element.classList.add('main-category-active')
    }

    const resetSelection = ()=>{
        mainCategories.forEach(mc=>{
            mc.classList.remove('main-category-active');
        })
    }

      const setCurrent = (id)=>{
         document.querySelector('#currentRequest').value = id
      }
      
      const loadAll = ()=>{
         $('#parDisplay').load('../../ajax/par.request.table.php');
    }

      const loadStatus= ()=>{
         $('#parDisplay').load('../../ajax/add.par.table.php');
    }
      const loadUnAdded = ()=>{
         $('#parDisplay').load('../../ajax/add.par.table.php');
    }

    loadAll()
    
    const setParId = (id)=>{
        parId = id;
    }


    

    const addParItem = (id,qty,jan,feb,mar,apr,may,june,july,aug,sep,oct,nov,dec)=>{
         $.post('../../ajax/add.par.php',{
            parId : id,
            parQty: qty,
            jan,
            feb,
            mar,
            apr,
            may,
            june,
            july,
            aug,
            sep,
            oct,
            nov,
            dec
         }).then(res=>{
            console.log(res)
            const added = JSON.parse(res);
            if(added.success){

            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Item Has Been Added!',
            showConfirmButton: false,
            timer: 1500
            })
             loadUnAdded()
             modalCloser.click()
             parItemQty.value = ''
            }
           
           
         })
           
    }
    const editPar = (id,qty)=>{
        parId = id;
        parEditItemQty.value = qty;
    }

    const submitEditPar = (id,qty)=>{
           $.post('../../ajax/editPar.php',{
            parId : id,
            parQty: qty
         }).then(res=>{
            const added = JSON.parse(res);
            console.log(added)
            if(added.success){
                
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Item Has Been Updated!',
            showConfirmButton: false,
            timer: 1500
            })
             loadAll()
             modalEditCloser.click()
            }
           
           
         })
    }

    const deletePar = (id)=>{
        Swal.fire({
        title: 'Are you sure?',
        text: "Item Will Be removed?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
             $.post('../../ajax/delete.par.php',{
            parDeleteId : id
         }).then(res=>{
            const removed = JSON.parse(res);
            if(removed.success){

            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Item Has Been Removed!',
            showConfirmButton: false,
            timer: 1500
            })
             loadAll()
            }
           
           
         })
           
        }
        })
    }

    const submitParRequest = (id)=>{
        Swal.fire({
        title: 'Are you sure?',
        text: "Request Will be sent to the Supplies Admin?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
             $.post('../../ajax/submitPar.php',{
            submitParId : id
         }).then(res=>{
            console.log(res)
            const sent = JSON.parse(res);
            if(sent.success){

            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Request Has been Sent',
            showConfirmButton: false,
            timer: 1500
            })
             loadAll()
            }
           
           
         })
           
        }
        })
    }
    
</script>