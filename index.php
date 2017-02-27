
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Shippers_Json</title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="bootstrap.js" type="text/javascript"></script>
  
</head>
<body >

  <style>

  </style>
  <div align="center">

    <div  >
     <h1>Справочник грузоотпровители</h1>
   </div>
   <div align="left" style="margin: 20px">
    <button id="modalAddButton" class="btn btn-primary" data-toggle="modal">Добавить</button>
    <button id="editButton" class="btn btn-warning" data-toggle="modal">Редактировать</button>
    <button id="deleteButton" class="btn btn-danger" onclick="deletRow()" >Удалить</button>
    
  </div>
  <div align="center">
    <table class="table table-bordered" style="margin-top: 20;">
      <thead>
        <tr>
          <td>
            <h3>Наименование</h3>
          </td>
          <td>
            <h3>Юридический адрес</h3>
          </td>
        </tr>
      </thead>
      <tbody id="tableBody">

      </tbody>
    </table>
  </div>
  
  
</div>


<!-- =================Modal============================ -->

<div id="myModal" align="center" class="modal fade" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-heder">
        <h1 id="heder">Добавить (редактировать) грузоотправителя!</h1>
      </div>
      <div id="addShippersModal" class="modal-body">
        <form id="addShippersForm" class="form-horizontal" role="form">
          <div class="form-group">
            <label for="Name" class="col-sm-3 control-label">Наименование</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="Name">
            </div>
          </div>
          <div class="form-group">
            <label for="Adress" class="col-sm-3 control-label">Адрес</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="Adress">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button id="addShippers" type="submit" class="btn btn-primary btn-lg btn-block">Добавить</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- =================Script============================ -->
  <script type="text/javascript"> 
    $(document).ready(function(){
      $.get("ajax.php", function(data){
        var data1 = JSON.parse(data);
        for (var i = 0; i < data1.length; i++) {
          $("#tableBody").append('<tr id='+data1[i].id+' class = "active" onclick =rowClick('+data1[i].id+')><td>'+ data1[i].name +
            '</td><td>'+data1[i].adress+'</td></tr>');
        }
      });
    });


    $("#modalAddButton").click(function(){
      if ($('#Name').val() !="" || $('#Adress').val() != "") {
        $('#Name').val('');
        $('#Adress').val('');
      }
      document.getElementById("heder").innerText = "Добавить грузоотправителя!";
      document.getElementById("addShippers").innerText = "Добавить";
      document.querySelector("#addShippers").setAttribute('onclick', "addShippersForm()");
      $("#myModal").modal('show');
    });

    function addShippersForm(){
      $("#addShippersForm").submit(function(event){
        event.preventDefault();
      });
      $.get('add_shippers.php', {'Name' : $('#Name').val(), 'Adress' : $('#Adress').val()},
        function (newSipper, Text) {
          newSipper = JSON.parse(newSipper);
          $("#tableBody").append('<tr id='+ newSipper.id +' class = "active" onclick =rowClick('+newSipper.id+')><td>'+ newSipper.name+
            '</td><td>'+ newSipper.adress+'</td></tr>');
        });
      $('#myModal').modal('hide');
    }


    function editShippersForm(id){
      $("#addShippersForm").submit(function(event){
       event.preventDefault();
     });
      $.post('edit_element.php',{'Name' : $('#Name').val(), 'Adress' : $('#Adress').val(), 'id' : id},
        function (editShipper) {
          editShipper = JSON.parse(editShipper);
          var editElements = document.getElementById(id);
          editElements.childNodes[0].innerText = editShipper.name;
          editElements.childNodes[1].innerText = editShipper.adress;

        });
      
      $('#myModal').modal('hide');
    }


    function rowClick(id){
      var row1 = document.getElementById(id);
      if (row1.className == 'active') {
        row1.className = 'success';
      } else if (row1.className == 'success') {
        row1.className = 'active';
      }
    }

    function deletRow(){
     var deleteIdArray = [];
     var tableBody = document.getElementById("tableBody");
     var delElements = document.querySelectorAll("tr.success");
     for (var i = 0; i < delElements.length; i++) {
      deleteIdArray[i] = delElements[i].getAttribute('id');
      tableBody.removeChild(delElements[i]);
    }
    $.post('remuveShippers.php', {'idArray' : deleteIdArray});
  }


  $("#editButton").click(function(){
    var editElement = document.querySelector("tr.success");
    $('#Name').val(editElement.childNodes[0].innerText);
    $('#Adress').val(editElement.childNodes[1].innerText);
    document.getElementById("heder").innerText = "Изменить грузоотправителя!";
    document.getElementById("addShippers").innerText = "Изменить";
    document.querySelector("#addShippers").setAttribute('onclick', "editShippersForm("+editElement.getAttribute('id')+")");
    $("#myModal").modal('show');
  });

  function viewCork(){
  }

</script>
</body>
</html>