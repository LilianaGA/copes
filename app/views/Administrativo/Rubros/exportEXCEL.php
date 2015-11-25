
<div class="container" style="margin-top:150px;">
  <h1>jQuery table2excel Demo</h1>
  <table class="table" id="table2excel">
    <thead>
      <tr class="noExl">
        <th>#</th>
        <th>Column heading</th>
        <th>Column heading</th>
        <th>Column heading</th>
      </tr>
      <tr>
        <th>#</th>
        <th>Column heading</th>
        <th>Column heading</th>
        <th>Column heading</th>
      </tr>
    </thead>
    <tbody>
      <tr class="active">
        <td>1</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr class="success">
        <td>3</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr class="info">
        <td>5</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr>
        <td>6</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr class="warning">
        <td>7</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
        </tr>
      <tr>
        <td>8</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
      <tr class="danger">
        <td>9</td>
        <td>Column content</td>
        <td>Column content</td>
        <td>Column content</td>
      </tr>
    </tbody>
  </table>
</div
<button class="btn btn-success">Export</button></div>

{{HTML::script('js/jquery.table2excel.js');}}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(function() {
        $("button").click(function(){
        $("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        }); 
         });
    });
</script>