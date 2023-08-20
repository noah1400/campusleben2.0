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
        event: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            qrCodeImage: null,
        }
    },
    methods: {
        generatePdf() {
            this.generateQrCodeImage();

            let logo = 'https://www.campusleben-es.de/storage/images/csm_logo_campusleben.png';
            let b64logo = null;
            fetch(logo)
                .then(res => res.blob())
                .then(blob => {
                    let reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        b64logo = reader.result;
                    }
                });

            const pdfContent = `
            <!DOCTYPE html>
<html>
<head>
<style>
    .document-container {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: auto;
        width: 70%;
        padding: 20px;
        border: 2px solid #333;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .info {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .qr-code {
        margin-top: 20px;
        text-align: center;
    }

    .logo {
        margin-top: 20px;
        text-align: center;
    }

    img {
        width: 200px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
</head>
<body>
    <div class="document-container">
        <div class="logo">
            <img src="${logo}" alt="Firmenlogo" />
        </div>
        <div class="title">
            ${this.event.name}
        </div>
        <div class="info">
            ${this.event.location}
        </div>
        <div class="info">
            ${this.event.start_date}
        </div>
        <div class="info">
            <p>Wir bitten Sie höflich, dieses Dokument beim Eintritt zur Veranstaltung mitzuführen und während des gesamten Verlaufs der Veranstaltung griffbereit zu halten.</p>
        </div>
        <div class="qr-code">
            <img src="${this.qrCodeImage}" alt="QR Code" />
        </div>
    </div>
</body>
</html>
            `;

            const pdfOptions = {
                margin: 10,
                filename: this.event.name + '-qr-code.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a5', orientation: 'portrait' }
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
