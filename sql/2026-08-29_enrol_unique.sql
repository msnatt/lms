-- Idempotent enrolment / access-grant support for the SMS + AMS redesign.
-- Adds a UNIQUE key on (course_id, user column) so course_enroll.php can use
-- INSERT ... ON DUPLICATE KEY UPDATE (re-enrol after un-enrol flips is_deleted
-- back to 0 instead of inserting a duplicate row).
--
-- Pre-check (must return zero rows before running the ALTERs):
--   SELECT course_id, owner_id, COUNT(*) c FROM course_student GROUP BY 1,2 HAVING c > 1;
--   SELECT course_id, user_id,  COUNT(*) c FROM course_access  GROUP BY 1,2 HAVING c > 1;

ALTER TABLE `course_student` ADD UNIQUE KEY `uq_course_owner` (`course_id`, `owner_id`);
ALTER TABLE `course_access`  ADD UNIQUE KEY `uq_course_user`  (`course_id`, `user_id`);
