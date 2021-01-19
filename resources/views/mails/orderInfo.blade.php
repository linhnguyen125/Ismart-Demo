<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Mail</title>
</head>

<body>
    <div style="text-align: center; background: #dfe6e9">
        <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td align="center"
                        style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"
                        valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px; margin-bottom: 15px"
                            width="600">
                            <tbody>
                                <tr>
                                    <td align="center" id="m_-7195676088979679342m_7360166094296294866headerImage"
                                        valign="bottom">
                                        <table cellpadding="0" cellspacing="0"
                                            style="border-bottom:3px solid #d9263c;padding-bottom:10px;background-color:#fff"
                                            width="100%">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="background:#fff">
                                    <td align="left" height="auto" style="padding:15px" width="600">
                                        <table>
                                            <tbody>

                                                <tr>
                                                    <td>
                                                        <h1
                                                            style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">
                                                            Cảm ơn quý khách {{ $fullname }} đã đặt hàng tại Ismart,
                                                        </h1>
                                                        <p
                                                            style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                            Ismart rất vui thông báo đơn hàng #{{ $orderCode }} của quý
                                                            khách đã
                                                            được
                                                            tiếp nhận
                                                            và đang trong quá trình xử lý. Ismart sẽ thông báo đến quý
                                                            khách
                                                            ngay khi hàng
                                                            chuẩn bị được giao.</p>
                                                        <h3
                                                            style="font-size:13px;font-weight:bold;color:#f12a43;text-transform:uppercase;margin:20px 0 0 0;border-bottom:1px solid #ddd">
                                                            Thông tin đơn hàng #{{ $orderCode }} <span
                                                                style="font-size:12px;color:#777;text-transform:none;font-weight:normal">({{ $created_at }})</span>
                                                        </h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th align="left"
                                                                        style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold"
                                                                        width="50%">Thông tin thanh toán</th>
                                                                    <th align="left"
                                                                        style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold"
                                                                        width="50%"> Địa chỉ giao hàng </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"
                                                                        valign="top"><span
                                                                            style="text-transform:capitalize">{{ $fullname }}</span><br>
                                                                        <a href="mailto:{{ $email }}" rel="noreferrer"
                                                                            target="_blank">{{ $email }}</a><br>
                                                                        {{ $phone }}
                                                                    </td>
                                                                    <td style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"
                                                                        valign="top"><span
                                                                            style="text-transform:capitalize">{{ $fullname }}</span><br>
                                                                        <a href="mailto:{{ $email }}" rel="noreferrer"
                                                                            target="_blank">{{ $email }}</a><br>
                                                                        {{ $address }}<br>
                                                                        Tel: {{ $phone }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"
                                                                        style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444"
                                                                        valign="top">
                                                                        <p
                                                                            style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                                            <strong>Phương thức thanh toán: </strong>
                                                                            {{ $paymentMethod }}<br>
                                                                            <strong>Thời gian giao hàng dự
                                                                                kiến:</strong> Dự
                                                                            kiến giao
                                                                            hàng sau 2 ngày - không giao ngày
                                                                            Chủ
                                                                            Nhật <br>
                                                                            <strong>Phí vận chuyển: </strong>
                                                                            0&nbsp;₫<br>
                                                                            <strong>Sử dụng bọc sách cao cấp Bookcare:
                                                                            </strong> Không
                                                                            <br>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p
                                                            style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                            <i>Lưu ý: Đối với đơn hàng đã được thanh toán trước, nhân
                                                                viên
                                                                giao nhận có
                                                                thể yêu cầu người nhận hàng cung cấp CMND / giấy phép
                                                                lái xe
                                                                để chụp ảnh
                                                                hoặc ghi lại thông tin.</i>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h2
                                                            style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:#f12a43">
                                                            CHI TIẾT ĐƠN HÀNG</h2>

                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            style="background:#f5f5f5" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th align="left" bgcolor="#f12a43"
                                                                        style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                        Sản phẩm</th>
                                                                    <th align="left" bgcolor="#f12a43"
                                                                        style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                        Đơn giá</th>
                                                                    <th align="left" bgcolor="#f12a43"
                                                                        style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                        Số lượng</th>
                                                                    <th align="left" bgcolor="#f12a43"
                                                                        style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                        Giảm giá</th>
                                                                    <th align="right" bgcolor="#f12a43"
                                                                        style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                                                        Tổng tạm</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody bgcolor="#eee"
                                                                style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                                @foreach (Cart::content() as $row)
                                                                    <tr>
                                                                        <td align="left" style="padding:3px 9px"
                                                                            valign="top">
                                                                            <span>{{ $row->name }}</span><br>
                                                                        </td>
                                                                        <td align="left" style="padding:3px 9px"
                                                                            valign="top">
                                                                            <span>{{ number_format($row->price, 0, ',', '.') }}&nbsp;₫</span>
                                                                        </td>
                                                                        <td align="left" style="padding:3px 9px"
                                                                            valign="top">{{ $row->qty }}
                                                                        </td>
                                                                        <td align="left" style="padding:3px 9px"
                                                                            valign="top">
                                                                            <span>0&nbsp;₫</span>
                                                                        </td>
                                                                        <td align="right" style="padding:3px 9px"
                                                                            valign="top">
                                                                            <span>{{ number_format($row->total, 0, ',', '.') }}&nbsp;₫</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                            <tfoot
                                                                style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                                <tr>
                                                                    <td align="right" colspan="4"
                                                                        style="padding:5px 9px">
                                                                        Tổng tạm tính
                                                                    </td>
                                                                    <td align="right" style="padding:5px 9px">
                                                                        <span>{{ Cart::total() }}&nbsp;₫</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="right" colspan="4"
                                                                        style="padding:5px 9px">
                                                                        Phí vận chuyển
                                                                    </td>
                                                                    <td align="right" style="padding:5px 9px">
                                                                        <span>0&nbsp;₫</span>
                                                                    </td>
                                                                </tr>
                                                                <tr bgcolor="#eee">
                                                                    <td align="right" colspan="4"
                                                                        style="padding:7px 9px">
                                                                        <strong><big>Tổng giá trị đơn hàng</big>
                                                                        </strong>
                                                                    </td>
                                                                    <td align="right" style="padding:7px 9px">
                                                                        <strong><big><span>{{ Cart::total() }}&nbsp;₫</span>
                                                                            </big>
                                                                        </strong>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                        <div style="margin:auto"><a href="{{ url('/') }}"
                                                                style="display:inline-block;text-decoration:none;background-color:#d9263c!important;margin-right:30px;text-align:center;border-radius:3px;color:#fff;padding:5px 10px;font-size:12px;font-weight:bold;margin-left:35%;margin-top:5px"
                                                                rel="noreferrer" target="_blank"
                                                                data-saferedirecturl="https://www.google.com/url?q=http://mg-email.Ismart.vn/c/eJwdjtuKwyAYhJ9GL4OHeLrwYqH0NRbj_2ukiRZjd9m3r10YmIEZhg_8plWCQItPSjmwwTIIQlnGIaZoN4dq5ZYbCWRl129JY8lYsYeBQHdvDWLQITGjgQnJXeIWdFjROXSbYfTw-xjPi8gvIu5TozzK8lNnusKB1_TWAfun6SE-Ss03HKEcRN5jAyTyZjUXjksjaPfP_dVqrvn1hzVtE21C5XPOl9hOOvz_13dsNZV-vgEK8UYq&amp;source=gmail&amp;ust=1602851091245000&amp;usg=AFQjCNGQorLCnUqmwPywPY9sCWQ4CJnwHw">Chi
                                                                tiết đơn hàng tại Ismart</a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;
                                                        <p
                                                            style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                            Trường hợp quý khách có những băn khoăn về đơn hàng, có thể
                                                            xem
                                                            thêm mục <a
                                                                href="http://mg-email.Ismart.vn/c/eJxNj81qxDAMhJ8mOQb_xIn34EOXsq-xKLbsmMZ2cJRd-vZ1Sg8FITGfhoFxZpmUd9BH45W6OQ2aORBKM-6st3q5oRq55rN03ciOd_Q0BMxYgdD1q-Ee-MwtjPPMF64ZjJPgYKUQapKjZ_1mVqK9kx-deLRZC9UyUPyKwytf2rb1itdTPk5Kz6Oc1WInP6lCPsBSLBm2TtwxQWx3ukwJXTxTM_2HhPVCWwnlj1hIO8SQG834bhmlOqx9Nft6lhxyOL8x-6U1bN3CFTXYknoyv76nLdnHmn4AxbBf1Q"
                                                                title="Các câu hỏi thường gặp" rel="noreferrer"
                                                                target="_blank"
                                                                data-saferedirecturl="https://www.google.com/url?q=http://mg-email.Ismart.vn/c/eJxNj81qxDAMhJ8mOQb_xIn34EOXsq-xKLbsmMZ2cJRd-vZ1Sg8FITGfhoFxZpmUd9BH45W6OQ2aORBKM-6st3q5oRq55rN03ciOd_Q0BMxYgdD1q-Ee-MwtjPPMF64ZjJPgYKUQapKjZ_1mVqK9kx-deLRZC9UyUPyKwytf2rb1itdTPk5Kz6Oc1WInP6lCPsBSLBm2TtwxQWx3ukwJXTxTM_2HhPVCWwnlj1hIO8SQG834bhmlOqx9Nft6lhxyOL8x-6U1bN3CFTXYknoyv76nLdnHmn4AxbBf1Q&amp;source=gmail&amp;ust=1602851091246000&amp;usg=AFQjCNGCsSjstwVSZQATzH04hcrdmm7EYg">
                                                                <strong>các câu hỏi thường gặp</strong>.</a></p>

                                                        <p
                                                            style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px #14ade5 dashed;padding:5px;list-style-type:none">
                                                            Từ ngày 14/2/2015, Ismart sẽ không gởi tin nhắn SMS khi đơn
                                                            hàng
                                                            của bạn được
                                                            xác nhận thành công. Chúng tôi chỉ liên hệ trong trường hợp
                                                            đơn
                                                            hàng có thể
                                                            bị trễ hoặc không liên hệ giao hàng được.</p>

                                                        <p
                                                            style="margin:10px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                                            Bạn cần được hỗ trợ ngay? Chỉ cần email <a
                                                                href="mailto:hethongcntt.unitop@gmail.com"
                                                                style="color:#099202;text-decoration:none"
                                                                rel="noreferrer" target="_blank">
                                                                <strong>hethongcntt.unitop@gmail.com</strong> </a>, hoặc
                                                            gọi số điện
                                                            thoại <strong style="color:#099202">0981-958-120</strong>
                                                            (8-21h cả
                                                            T7,CN). Đội
                                                            ngũ Ismart Care luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;
                                                        <p
                                                            style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">
                                                            Một lần nữa Ismart cảm ơn quý khách.</p>

                                                        <p
                                                            style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right">
                                                            <strong><a href="{{ url('/') }}" style="
                                                                    color:#00a3dd;text-decoration:none;font-size:14px"
                                                                    rel="noreferrer" target="_blank">Ismart</a>
                                                            </strong>
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
            </tbody>
        </table>
    </div>
</body>

</html>
