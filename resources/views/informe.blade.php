
<table class="" style="width:50%;">
                    <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Tiempo </th>
                        <th>Valor $</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{$row->placa }} </td>
                            <td>{{ (0.05 / $row->valor) }}  </td>
                            <td>{{$row->valor }}  </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


<script>
    this.print({bUI: false, bSilent: true, bShrinkToFit: true});
</script>