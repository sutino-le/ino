<?= $this->extend('main/layout'); ?>

<?= $this->section('judul') ?>
<?= $judul ?>
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>
<?= $subjudul ?>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<div class="container-fluid">
    <script src="https://balkan.app/js/OrgChart.js"></script>
    <style>
    html,
    body {
        margin: 0px;
        padding: 0px;
        width: 100%;
        height: 100%;
        overflow: hidden;
        font-family: Helvetica;
    }

    #tree {
        width: 100%;
        height: 100%;
    }

    /*partial*/
    .tree-layout line {
        stroke: #f57c00;
    }
    </style>


    <div id="tree"></div>



    <script>
    $(document).ready(function() {
        function tampilBagian() {
            $.ajax({
                url: "<?= base_url() ?>/hrstruktur/tampilData/",
                dataType: "json",
                success: function(response) {
                    let databagian = response.sukses;

                    console.log(databagian);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    });




    window.onload = function() {
        var chart = new OrgChart(document.getElementById("tree"), {
            template: "ula",
            toolbar: {
                layout: true,
                zoom: true,
                fit: true,
                expandAll: false
            },

            layout: OrgChart.tree,
            align: OrgChart.ORIENTATION,
            nodeBinding: {
                field_0: "name",
                field_1: "title",
                img_0: "img"
            },
            collapse: {
                level: 2
            },
            expand: {
                nodes: [2, 3, 4],
                allChildren: true
            },


            nodes: [{
                    id: 1,
                    name: "Jack Hill",
                    title: "Chairman and CEO",
                    email: "amber@domain.com",
                    img: "https://cdn.balkan.app/shared/1.jpg"
                },
                {
                    id: 2,
                    pid: 1,
                    name: "Lexie Cole",
                    title: "QA Lead",
                    email: "ava@domain.com",
                    img: "https://cdn.balkan.app/shared/2.jpg"
                },
                {
                    id: 3,
                    pid: 1,
                    name: "Janae Barrett",
                    title: "Technical Director",
                    img: "https://cdn.balkan.app/shared/3.jpg"
                },
                {
                    id: 4,
                    pid: 1,
                    name: "Aaliyah Webb",
                    title: "Manager",
                    email: "jay@domain.com",
                    img: "https://cdn.balkan.app/shared/4.jpg"
                },
                {
                    id: 5,
                    pid: 2,
                    name: "Elliot Ross",
                    title: "QA",
                    img: "https://cdn.balkan.app/shared/5.jpg"
                },
                {
                    id: 6,
                    pid: 2,
                    name: "Anahi Gordon",
                    title: "QA",
                    img: "https://cdn.balkan.app/shared/6.jpg"
                },
            ]
        });
    };
    </script>
</div>

<?= $this->endSection('isi') ?>