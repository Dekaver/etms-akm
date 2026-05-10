<table cellspacing="0" border="1">
    <colgroup width="145"></colgroup>
    <colgroup span="{{ $total_days }}" width="35"></colgroup>
    <colgroup width="101"></colgroup>
    <colgroup span="3" width="55"></colgroup>
    <colgroup span="3" width="90"></colgroup>
    <tr>
        <td height="45" colspan="{{ $total_days + 8 }}" align="left" valign=top><b>
                <font size=6 color="#4B180E">DAILY INSPECTION REPORT</font>
            </b></td>

    </tr>
    <tr>
        <td height="20" align="right" valign=middle bgcolor="#D7DFBE"><b>
                <font color="#000000"><br></font>
            </b></td>
        <td align="center" valign=middle bgcolor="#DE7566"><b>
                <font color="#000000">V</font>
            </b></td>
        <td colspan=3 align="left" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">Inspection</font>
        </td>
        <td align="center" valign=middle bgcolor="#F5CDAC"><b>
                <font color="#000000">R</font>
            </b></td>
        <td colspan=3 align="left" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">Remove</font>
        </td>
        <td align="center" valign=middle bgcolor="#C3D09E"><b>
                <font color="#000000">I</font>
            </b></td>
        <td colspan=2 align="left" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">Install</font>
        </td>
        <td align="center" valign=middle bgcolor="#FFE085" sdnum="1033;0;0;0;;"><b>
                <font color="#000000"><br></font>
            </b></td>
        <td colspan=3 align="left" valign=middle bgcolor="#F1F2E8">
            <font color="#000000"><br></font>
        </td>
        <td align="center" valign=middle bgcolor="#B8C2DF" sdnum="1033;0;0;0;;"><b>
                <font color="#000000"><br></font>
            </b></td>
        <td colspan=3 align="left" valign=middle bgcolor="#F1F2E8">
            <font color="#000000"><br></font>
        </td>
        <td colspan="{{ $total_days - 19 }}" align="left" valign=middle>
            <font color="#000000"><br></font>
        </td>
        <td align="left" valign=middle>
            <font color="#000000"><br></font>
        </td>
    </tr>
    <tr>
        <td colspan="{{ $total_days + 8 }}">

        </td>
    </tr>
    <tr>
        <td height="31" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=5 color="#7C271A">{{ $month->isoFormat('MMMM') }}</font>
            </b></td>
        <td colspan={{ $total_days }} align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=5 color="#7C271A">Dates of Inspection</font>
            </b></td>
        <td align="center" valign=middle bgcolor="#F1F2E8" sdval="2022" sdnum="1033;"><b>
                <font size=5 color="#7C271A">2022</font>
            </b></td>
    </tr>
    <tr>
        <td rowspan="2" height="20" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Unit Number</font>
            </b></td>
        @foreach ($period as $date)
            <td align="center" valign=middle>
                <font color="#000000">{{ $date->isoFormat('ddd') }}</font>
            </td>
        @endforeach
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Total Days</font>
            </b></td>
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Total R</font>
            </b></td>
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Total V</font>
            </b></td>
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Total I</font>
            </b></td>
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Tgl Last R</font>
            </b></td>
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Tgl Last V</font>
            </b></td>
        <td rowspan="2" align="center" valign=middle bgcolor="#F1F2E8"><b>
                <font size=4 color="#7C271A">Tgl Last I</font>
            </b></td>
    </tr>
    <tr>
        @foreach ($period as $date)
            <td align="center" bgcolor="#f3fAf1" valign=middle>
                <font color="#ffffff">{{ $date->format('d') }}</font>
            </td>
        @endforeach
    </tr>
    @php
        $jumlah = [];

    @endphp

    @forelse ($data as $key => $item)
        <tr>
            <td height="20" align="left" valign=middle>
                <font color="#000000">{{ $key }}</font>
            </td>
            @php
                $total = 0;
            @endphp
            @foreach ($item as $k => $v)
                @php
                    if ($v != '-') {
                        $total += 1;
                        $jumlah[$k] = ($jumlah[$k] ?? 0) + 1;
                    } else {
                        $jumlah[$k] = ($jumlah[$k] ?? 0) + 0;
                    }
                @endphp
                <td align="center" valign=middle>
                    <font color="#000000">{{ $v }}</font>
                </td>
            @endforeach
            <td align="center" valign=middle sdval="0" sdnum="1033;0;0">
                <font color="#000000">{{ $total }}</font>
            </td>
            <td align="center" valign=middle>
                <font color="#000000">{{ $totals[$key]['R'] ?? 0 }}</font>
            </td>
            <td align="center" valign=middle>
                <font color="#000000">{{ $totals[$key]['V'] ?? 0 }}</font>
            </td>
            <td align="center" valign=middle>
                <font color="#000000">{{ $totals[$key]['I'] ?? 0 }}</font>
            </td>
            <td align="center" valign=middle>
                <font color="#000000">{{ !empty($lastInspect[$key]['R']) ? $lastInspect[$key]['R']->format('Y-m-d') : '-' }}</font>
            </td>
            <td align="center" valign=middle>
                <font color="#000000">{{ !empty($lastInspect[$key]['V']) ? $lastInspect[$key]['V']->format('Y-m-d') : '-' }}</font>
            </td>
            <td align="center" valign=middle>
                <font color="#000000">{{ !empty($lastInspect[$key]['I']) ? $lastInspect[$key]['I']->format('Y-m-d') : '-' }}</font>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="{{ $total_days + 8 }}" align="center">No Data</td>
        </tr>
    @endforelse
    <tr>
        <td height="20" align="left" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">{{ $date->isoFormat('MMMM') }} Total</font>
        </td>
        @forelse ($jumlah as $item)
            <td align="center" valign=middle sdval="0" sdnum="1033;0;0;0;;" bgcolor="#F1F2E8">
                <font color="#000000">{{ $item }}</font>
            </td>
        @empty
            @for ($i = 0; $i < $total_days; $i++)
                <td align="center" valign=middle sdval="0" sdnum="1033;0;0;0;;" bgcolor="#F1F2E8">
                    <font color="#000000">0wes</font>
                </td>
            @endfor
        @endforelse
        <td align="center" valign=middle sdval="9" sdnum="1033;0;0;0;;" bgcolor="#F1F2E8">
            <font color="#000000">{{ array_sum($jumlah) }}</font>
        </td>
        <td align="center" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">{{ array_sum(array_column($totals, 'R')) }}</font>
        </td>
        <td align="center" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">{{ array_sum(array_column($totals, 'V')) }}</font>
        </td>
        <td align="center" valign=middle bgcolor="#F1F2E8">
            <font color="#000000">{{ array_sum(array_column($totals, 'I')) }}</font>
        </td>
        <td align="center" valign=middle bgcolor="#F1F2E8">
            <font color="#000000"></font>
        </td>
        <td align="center" valign=middle bgcolor="#F1F2E8">
            <font color="#000000"></font>
        </td>
        <td align="center" valign=middle bgcolor="#F1F2E8">
            <font color="#000000"></font>
        </td>
    </tr>
</table>
