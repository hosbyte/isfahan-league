// ! test jquery
// * jquery test
$(document).ready(function () {
  console.log("jQuery loaded"); 
});

// ! register page
// * register 
$(document).ready(function () {
    $('#register').on('submit' , function(e) {
        e.preventDefault();
        const team_id = $('#dropdown').val();
        const gf = $('#gf').val();
        const ga = $('#ga').val();

        if(!team_id || !gf || !ga){
            alert("لطفاً تمام فیلدها را پر کنید.");
            return;
        }

        $.ajax({
            url : 'register.php',
            method : 'POST',
            data :{
                team_id : $('#dropdown').val(),
                gf : $('#gf').val(),
                ga : $('#ga').val()
            },
            success : function(reg){
                reg = reg.trim();
                console.log(">>>"+reg+"<<<");
                if(reg ==='1'){ 
                    window.location.href = 'register.php';
                    console.log(reg);
                    console.log("yes");
                  }
                  else{
                    alert ("ثبت انجام نشد");
                    console.log(reg);
                    console.log("no");
                  }
            },
            error : function(){
                alert ("اتصال انجام نشد");
            },
        });
    });
});

// * select table
$(document).ready(function () {
    $('#leaguetable').on('submit' , function(e) {
        e.preventDefault();
        const table = $('#table').val();

        if(!table){
            alert("لطفاً تمام فیلدها را پر کنید.");
            return;
        }

        $.ajax({
            url : 'register.php',
            method : 'POST',
            data :{
                table : $('#table').val(),
            },
            success : function(show_t){
                show_t = show_t.trim();
                if(show_t ==='1'){ 
                    window.location.href = 'register.php';
                  }
                  else{
                    alert ("جدول انتخاب نشد");
                  }
            },
            error : function(){
                alert ("اتصال انجام نشد");
            },
        });
    });
});

// ! teamedit page
// * show table
$(document).ready(function () {
    $('#teamtable').on('submit' , function(e) {
        e.preventDefault();
        const table = $('#table').val();

        if(!table){
            alert("لطفاً تمام فیلدها را پر کنید.");
            return;
        }

        $.ajax({
            url : 'teamedit.php',
            method : 'POST',
            data :{
                table : $('#table').val(),
            },
            success : function(show_t){
                show_t = show_t.trim();
                console.log(show_t);
                if(show_t ==='1'){
                    console.log("yes" + show_t);
                    window.location.href = 'teamedit.php';
                  }
                  else{
                    console.log("no" + show_t);
                    alert ("جدول انتخاب نشد");
                  }
            },
            error : function(){
                alert ("اتصال انجام نشد");
            },
        });
    });
});

// * modal show jquery 
$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('edit')) {
        const myModal = new bootstrap.Modal(document.getElementById('editmodal'));
        myModal.show();
    }
});

// * delete all jquery
$(document).ready(function() {
    $("#delete_all").click(function() {
        if (confirm("آیا مطمئن هستید که می‌خواهید تمام تیم‌ها حذف شوند؟")) {
            $.ajax({
                url: 'teamedit.php',
                type: 'POST',
                data: { delete_all: true },
                success: function(response) {
                    alert(response);
                    location.reload(); // برای بروز شدن جدول بعد از حذف
                },
                error: function(xhr, status, error) {
                    alert("خطا در حذف: " + error);
                }
            });
        }
    });
});