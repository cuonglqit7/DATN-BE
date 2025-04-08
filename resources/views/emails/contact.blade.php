<div style="font-family: Arial, sans-serif; background-color: #f6f8fa; padding: 20px;">
  <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <div style="background-color: #007BFF; padding: 20px; color: #ffffff; text-align: center;">
      <h1 style="margin: 0;">📨 Tin nhắn mới từ {{ $data['name'] }}</h1>
    </div>
    <div style="padding: 20px; color: #333;">
      <p><strong>📞 Số điện thoại:</strong> {{ $data['phone'] }}</p>
      <p><strong>📧 Email:</strong> <a href="mailto:{{ $data['email'] }}" style="color: #007BFF;">{{ $data['email'] }}</a></p>
      <p><strong>💬 Nội dung tin nhắn:</strong></p>
      <div style="background-color: #f1f1f1; padding: 15px; border-left: 4px solid #007BFF; border-radius: 4px; white-space: pre-line;">
        {{ $data['message'] }}
      </div>
    </div>
    <div style="padding: 15px; background-color: #f9f9f9; text-align: center; font-size: 13px; color: #777;">
      Email này được gửi từ biểu mẫu liên hệ trên website Tea Bliss.
    </div>
  </div>
</div>
