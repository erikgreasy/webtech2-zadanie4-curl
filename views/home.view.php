<?php include 'header.php' ?>

<main>
    <div class="container-fluid">
        <table class="table" id="home-table" >
            <thead>
                <tr>
                    <th>
                        <form action="#" method="GET">
                            <input type="hidden" name="orderBy" value="student">
                            <input type="hidden" name="order" value="<?= isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <button type="submit">Študent</button>
                        </form>
                    </th>
                    <?php foreach( $lectures as $index => $lecture ): ?>
                        <th class="sorttable_nosort">
                            <?= 'Predn. ' . ++$index . ' - ' . date( 'd.m.Y', strtotime($lecture->getDate()) ) ?>
                        </th>

                    <?php endforeach; ?>
                    <th>
                        <form action="#" method="GET">
                            <input type="hidden" name="orderBy" value="student">
                            <input type="hidden" name="order" value="<?= isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <button type="submit">Počet účastí</button>
                        </form>
                    </th>
                    <th>
                        <form action="#" method="GET">
                            <input type="hidden" name="orderBy" value="student">
                            <input type="hidden" name="order" value="<?= isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'DESC' : 'ASC' ?>">
                            <button type="submit">Počet minút na prednáškach</button>
                        </form>
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php foreach( $students as $student ): ?>
                    <tr>
                        <td>
                            <?= $student->getName() ?>
                        </td>
                        <?php foreach( $lectures as $lecture ): ?>
                            <td>
                                <span class="submit-form-span"><?= $student->timeOnLecture( $lecture ) ?></span>

                                <form action="#" class="lectureStudentDetail d-none">
                                    <input type="hidden" name="student_id" value="<?= $student->getId() ?>">
                                    <input type="hidden" name="lecture_id" value="<?= $lecture->getId() ?>">

                                    <button type="submit">
                                        <?= $student->timeOnLecture( $lecture ) ?>
                                    </button>
                                </form>
                                
                            </td>
                        <?php endforeach; ?>
                    
                        
                        <td>
                            <?= $student->totalLectures() ?>
                        </td>

                        <td>
                            <?= $student->timeOnLectures() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    
    </div>

    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavrieť</button>
        </div>
        </div>
    </div>
    </div>
</main>

<?php include 'footer.php' ?>
