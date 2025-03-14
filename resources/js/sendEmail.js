import jsPDF from 'jspdf';
import axios from 'axios';

document.getElementById('sendEmailButton').addEventListener('click', async () => {
    const doc = new jsPDF();
    doc.text('Scoring Evaluation', 10, 10);
    // Add more content to the PDF as needed
    const pdfData = doc.output('blob');

    const formData = new FormData();
    formData.append('pdf', pdfData, 'evaluation.pdf');

    try {
        await axios.post('/send-email', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        alert('Email sent successfully!');
    } catch (error) {
        console.error('Error sending email:', error);
        alert('Failed to send email.');
    }
});
