-- Exam system hardening (2026-08-30)
-- Pre-checked: user_answers / course_points have zero duplicate rows; every
-- question has exactly one is_correct choice. ALTER is safe.

-- 1. exam_period was tinyint(4) -> silently truncated anything over 127 minutes.
ALTER TABLE `question_sets` MODIFY `exam_period` SMALLINT UNSIGNED DEFAULT NULL;

-- 2. One answer row per (student, exam, question) so exam_answers.php can use
--    INSERT ... ON DUPLICATE KEY UPDATE instead of check-then-insert-in-a-loop.
ALTER TABLE `user_answers`
  ADD UNIQUE KEY `uq_user_exam_question` (`user_id`, `exam_id`, `question_id`);

-- 3. One score row per (student, course, unit, exam) so exam_point.php can
--    upsert (the old UPDATE-only path silently discarded scores for students
--    who enrolled after the exam content block was saved).
ALTER TABLE `course_points`
  ADD UNIQUE KEY `uq_user_course_unit_exam` (`user_id`, `course_id`, `unit_id`, `exam_id`);
