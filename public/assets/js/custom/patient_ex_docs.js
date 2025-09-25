document.addEventListener("DOMContentLoaded", function () {
    Dropzone.autoDiscover = false;

    var validationMsg = document.getElementById('validationMsg');
    var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
    url: window.patientConfig.storeUrl,
    autoProcessQueue: false,
    paramName: "file",
    maxFiles: 10,
    parallelUploads: 10,
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': window.patientConfig.csrfToken
    },
        accept: function(file, done) {
            const maxFileSize = 10 * 1024 * 1024; // 10 MB in bytes
            if (file.size > maxFileSize) {
                validationMsg.innerHTML = 'File "' + file.name + '" is too big. Maximum size allowed is 10 MB.';
                validationMsg.style.display = 'block';

                // Remove file from Dropzone preview
                // this.removeFile(file);
                file.status = Dropzone.CANCELED;

                done("File too large");
            } else {
                // Hide message if valid
                validationMsg.style.display = 'none';
                done();
            }
        },
        sending: function(file, xhr, formData) {
            formData.append('patient_id', document.getElementById('patient_id').value);
        },
        success: function(file, response) {
            file.document_id = response.document_id;
        },
        removedfile: function(file) {
            if (file.previewElement != null && file.previewElement.parentNode != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }
        }
    });
    document.getElementById('uploadAllFilesBtn').addEventListener('click', function () {
            if (myDropzone.getQueuedFiles().length > 0) {
                myDropzone.processQueue();
            } else {
                validationMsg.innerHTML = 'No files selected';
                validationMsg.style.display = 'block';
                // document.getElementById('noFilesMsg').style.display = 'block';
            }
        });
    myDropzone.on("queuecomplete", function () {
        // refreshDocumentTable();
        myDropzone.removeAllFiles();
        window.location.href = window.patientConfig.documentsListUrl;
    });
    Livewire.on('open-document-preview', (data) => {
        window.open(data.url, '_blank');
    });
});
