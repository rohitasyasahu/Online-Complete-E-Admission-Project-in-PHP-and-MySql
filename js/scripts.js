

<script>
    function fetchSubjects(streamId) {
        if (streamId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_subjects.php?stream_id=' + streamId, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    try {
                        const subjects = JSON.parse(this.responseText);
                        let options = '<option value="">Select Subject</option>';
                        subjects.forEach(subject => {
                            options += `<option value="${subject.id}">${subject.subject_name}</option>`;
                        });
                        document.getElementById('subject').innerHTML = options;
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                } else {
                    console.error('Error fetching subjects:', this.status);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();
        } else {
            document.getElementById('subject').innerHTML = '<option value="">Select Subject</option>';
        }
    }
</script>
