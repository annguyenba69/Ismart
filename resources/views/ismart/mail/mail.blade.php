<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#dcf0f8"
    style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
    <tbody>
        <tr>
            <td align="center" valign="top"
                style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">

                <table border="0" cellpadding="0" cellspacing="0" width="600" style="margin-top:15px">
                    <tbody>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="line-height:0">
                                    <tbody>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="bottom"
                                id="m_8070231026732340780m_-387904710213205839m_1333241270083658938headerImage">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td valign="top" bgcolor="#FFFFFF" width="100%" style="padding:0">
                                                <div style="color:#fff;font-size:11px">Tổng giá trị đơn hàng là
                                                    <span>{{Cart::total(0,'.',',')}}&nbsp;₫</span>.
                                                    - Miễn phí vận chuyển</div>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr style="background:#fff">
                            <td align="left" width="600" height="auto" style="padding:15px">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p>Chào quý khách,</p>
                                                <p>[ISMART] gửi đến quý khách hóa đơn điện tử cho đơn hàng {{$id}}, Quý
                                                    khách vui lòng kiểm
                                                    tra hóa đơn điện tử bằng cách xem chi tiết bên dưới.</p>
                                                <p><b>Lưu ý:</b></p>
                                                <ul>
                                                    <li>Không nên tiết lộ thông tin hóa đơn cho người khác </li>
                                                    <li>Hóa đơn cho các sản phẩm của nhà cung cấp khác ISMART sẽ được
                                                        xuất trong vòng 14 ngày kể
                                                        từ thời điểm nhận hàng và không phát sinh yêu cầu đổi trả.</li>
                                                </ul>
                                                <h3
                                                    style="font-size:13px;font-weight:bold;color:#02acea;text-transform:uppercase;margin:20px 0 0 0;border-bottom:1px solid #ddd">
                                                    Thông tin đơn hàng #{{$id}}
                                                    <span
                                                        style="font-size:12px;color:#777;text-transform:none;font-weight:normal">({{$created_at}})</span>
                                                </h3>
                                            </td>
                                        </tr>
                                        <tr>
                                        </tr>
                                        <tr>
                                            <td
                                                style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" width="50%"
                                                                style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold">
                                                                Thông tin thanh toán</th>
                                                            <th align="left" width="50%"
                                                                style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold">
                                                                Địa chỉ giao hàng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top"
                                                                style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">

                                                                <span style="text-transform:capitalize">{{$name}}</span>
                                                                <br> <a href="mailto:{{$email}}"
                                                                    target="_blank">{{$email}}</a>
                                                                <br> {{$phone}}

                                                            </td>
                                                            <td valign="top"
                                                                style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                                {{$name}}<br>{{$address}}<br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top"
                                                                style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444"
                                                                colspan="2">
                                                                <p
                                                                    style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:normal">
                                                                    <br>
                                                                    <strong>Phí vận chuyển: </strong>0đ (Miễn phí)
                                                                    <br>
                                                                    <strong>Phương thức thanh toán:
                                                                    </strong>{{$payment_method}}


                                                                    <br>
                                                                    <strong>Xuất hóa đơn điện tử: </strong>{{$name}}
                                                                    <br> -------
                                                                    <br>{{$address}}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2
                                                    style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:#02acea">
                                                    CHI TIẾT ĐƠN HÀNG</h2>
                                                <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                                    style="background:#f5f5f5">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" bgcolor="#02acea"
                                                                style="padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                Sản phẩm</th>
                                                            <th align="left" bgcolor="#02acea"
                                                                style="padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                Đơn giá</th>
                                                            <th align="left" bgcolor="#02acea"
                                                                style="padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                Số lượng</th>
                                                            <th align="left" bgcolor="#02acea"
                                                                style="padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                Giảm giá</th>
                                                            <th align="right" bgcolor="#02acea"
                                                                style="padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                Tổng tạm</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody bgcolor="#eee"
                                                        style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                        @foreach ($detail_order as $product)
                                                        <tr>
                                                            <td align="left" valign="top" style="padding:3px 9px">
                                                                <strong>{{$product->name}}</strong>
                                                            </td>
                                                            <td align="left" valign="top" style="padding:3px 9px">
                                                                <span>{{$product->total(0,'.',',')}}&nbsp;₫</span></td>
                                                            <td align="left" valign="top" style="padding:3px 9px">
                                                                {{$product->qty}}</td>
                                                            <td align="left" valign="top" style="padding:3px 9px">
                                                                <span>0,00&nbsp;₫</span></td>
                                                            <td align="right" valign="top" style="padding:3px 9px">
                                                                <span>{{$product->total(0,'.',',')}}&nbsp;₫</span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>

                                                    <tfoot
                                                        style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                        <tr>
                                                            <td colspan="4" align="right" style="padding:5px 9px">Tổng
                                                                giá trị sản phẩm chưa giảm</td>
                                                            <td align="right" style="padding:5px 9px">
                                                                <span>{{Cart::total(0,'.',',')}}&nbsp;₫</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right" style="padding:5px 9px">Giảm
                                                                giá Phiếu Quà Tặng</td>
                                                            <td align="right" style="padding:5px 9px">
                                                                <span>0,00&nbsp;₫</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right" style="padding:5px 9px">Chi
                                                                phí vận chuyển</td>
                                                            <td align="right" style="padding:5px 9px">
                                                                <span>0,00&nbsp;₫</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right" style="padding:5px 9px">Phí xử
                                                                lý đơn hàng</td>
                                                            <td align="right" style="padding:5px 9px">
                                                                <span>0,00&nbsp;₫</span></td>
                                                        </tr>
                                                        <tr bgcolor="#eee">
                                                            <td colspan="4" align="right" style="padding:7px 9px">
                                                                <strong><big>Tổng giá trị đơn
                                                                        hàng</big></strong></td>
                                                            <td align="right" style="padding:7px 9px">
                                                                <strong><big><span>{{Cart::total(0,'.',',')}}&nbsp;₫</span></big></strong>
                                                            </td>
                                                        </tr>
                                                    </tfoot>

                                                </table>

                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p
                                                    style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                    Xem thêm
                                                    <a href="http://mg-email.tiki.vn/c/eJxNkEtuxCAMhk8Du0bmETIsWISms2vVG4wokARNgBEh0-uXSLOoZNn6P79kO_Uj-tkZHBQFCiDpQAQIwjvS6Q-iiZzGix4nyfSEONRwD90z4VVJdpllD0Mvac-dkbNnM4eBkwvxAGBx9PtuFn9zphqFBo0oDa45xEZCGe8FGia8qbXWR0OIXputuZbcvZac2jb3DGeSXY8ab3s-ivWITbWYtBtbQ05mQ1T7aEKL4iyK3oUjtqL_sPpyoi0v-UWsiQ8TltRo8r9tRi7OF1zU1vrSao-cFgIg2legnb6cwzqbI67q_fvr7bPJPyZoYZk"
                                                        title="Các câu hỏi thường gặp " target="_blank"
                                                        data-saferedirecturl="https://www.google.com/url?q=http://mg-email.tiki.vn/c/eJxNkEtuxCAMhk8Du0bmETIsWISms2vVG4wokARNgBEh0-uXSLOoZNn6P79kO_Uj-tkZHBQFCiDpQAQIwjvS6Q-iiZzGix4nyfSEONRwD90z4VVJdpllD0Mvac-dkbNnM4eBkwvxAGBx9PtuFn9zphqFBo0oDa45xEZCGe8FGia8qbXWR0OIXputuZbcvZac2jb3DGeSXY8ab3s-ivWITbWYtBtbQ05mQ1T7aEKL4iyK3oUjtqL_sPpyoi0v-UWsiQ8TltRo8r9tRi7OF1zU1vrSao-cFgIg2legnb6cwzqbI67q_fvr7bPJPyZoYZk&amp;source=gmail&amp;ust=1644481746925000&amp;usg=AOvVaw3tJ8p6RqJlGXsv25M0FjP7"><strong>các
                                                            câu hỏi thường gặp</strong>.</a>
                                                </p>
                                                <p
                                                    style="margin:10px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                    Mọi thắc mắc và góp ý, quý khách vui lòng liên hệ với ISMART CARE
                                                    qua số điện thoại : 0377888999
                                                    Đội ngũ ISMART CARE luôn sẵn sàng hỗ trợ bạn.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <br>
                                                <p
                                                    style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">
                                                    ISMART cảm ơn quý khách,
                                                    <br>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center ">
                <table width="600 ">
                    <tbody>
                        <tr>
                            <td>
                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:18px;color:#4b8da5;padding:10px 0;margin:0px;font-weight:normal"
                                    align="left ">
                                    Quý khách nhận được email này vì đã mua hàng tại ISMART<br>
                                    Để chắc chắn luôn nhận được email thông báo, xác nhận mua hàng từ ISMART, quý khách
                                    vui lòng thêm địa
                                    chỉ <strong>noreply@ismart</strong> vào số địa chỉ (Address Book, Contacts) của hộp
                                    email. <br>
                                    <b>Văn phòng Ismart:</b> 52 Út Tịch, Phường 4, Quận Tân Bình, Thành phố Hồ Chí Minh,
                                    Việt Nam
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>