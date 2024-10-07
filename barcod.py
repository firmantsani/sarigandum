import barcode
from barcode.writer import ImageWriter
from PIL import Image
def create_barcodes_from_file(filename, template_filename):
    with open(filename, 'r') as file:
        vouchers = file.readlines()
    vouchers = [voucher.strip() for voucher in vouchers if voucher.strip()]
    template = Image.open(template_filename)
    template_width, template_height = template.size
    barcode_width = int(template_width * 0.7)
    barcode_height = int(barcode_width / 3)
    module_height = 15
    for voucher in vouchers:
        code = barcode.get('code128', voucher, writer=ImageWriter())
        barcode_filename = f'barcode_{voucher}'
        code.save(barcode_filename, options={
            'width': barcode_width,
            'height': barcode_height,
            'module_height': module_height
        })
        barcode_image = Image.open(barcode_filename+".png")
        barcode_image_resized = barcode_image.resize((barcode_width, barcode_height), Image.LANCZOS)
        position = (int((template_width - barcode_image_resized.width) / 2), template_height - barcode_image_resized.height - 150)
        template_copy = template.copy()
        template_copy.paste(barcode_image_resized, position)
        output_filename = f'output_{voucher}.png'
        template_copy.save(output_filename)
create_barcodes_from_file('voucher_sarigandum.txt', 'mentah.png')