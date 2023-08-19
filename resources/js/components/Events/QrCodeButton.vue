<template>
    <div>
        <button @click="generatePdf" class="btn btn-primary">Generate QR Code</button>
    </div>
</template>

<script>
import qrcode from 'qrcode';
import html2pdf from 'html2pdf.js';

export default {
    name: "QrCodeButton",
    props: {
        link: String,
    },
    data() {
        return {
            qrCodeImage: null,
        }
    },
    methods: {
        generatePdf() {
            this.generateQrCodeImage();

            const pdfContent = `
                <div style="text-align: center">
                    <img src="${this.qrCodeImage}" alt="QR Code" style="width: 100%" />
                </div>
            `;

            const pdfOptions = {
                margin: 50,
                filename: 'qr-code.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            const element = document.createElement('div');
            element.innerHTML = pdfContent;

            html2pdf().from(element).set(pdfOptions).save();
        },
        generateQrCodeImage() {
                let vm = this;

                qrcode.toDataURL(this.link, (err, url) => {
                    if (err) throw err;
                    this.qrCodeImage = url;
                });
        }
    }
}
</script>
