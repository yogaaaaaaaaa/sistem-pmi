<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 200px;">
                Nama
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 250px;">
                Alamat
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 250px;">
                No Telpon
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 250px;">
                Negara
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 250px;">
                Sektor
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 250px;">
                Keperluan
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 300px;">
                Jenis Layanan
            </th>
            <th style="border: 1px solid #000;text-align: center;font-weight: bold;padding: 8px;width: 120px;">
                Tanggal
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $row)
        <tr>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->nama }}
            </td>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->alamat }}
            </td>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->no_telpon }}
            </td>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->negara }}
            </td>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->sektor }}
            </td>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->keperluan }}
            </td>
            <td style="border: 1px solid #000; text-align: center;padding: 8px; white-space: normal;">
                {{ $row->jenis_layanan }}
            </td>
            <td style="border: 1px solid #000; text-align: center; padding: 8px;">
                {{ $row->created_at->format('d-m-Y') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
