-- =====================================================
-- Performance Optimization Indexes
-- Created: 2025-12-28
-- Purpose: Improve query performance for /hocbai page
-- =====================================================

-- Index for logs_point queries (account_id, task_type_point)
-- Used in: getCountPointForType() - GROUP BY account_id, task_type_point
ALTER TABLE c19_logs_point 
ADD INDEX IF NOT EXISTS idx_account_type (account_id, task_type_point);

-- Index for logs_point with type filter
ALTER TABLE c19_logs_point 
ADD INDEX IF NOT EXISTS idx_account_id (account_id);

-- Index for logs_play queries (account_id, status)
-- Used in: checkExistLogsPlay() - WHERE account_id AND status
ALTER TABLE c19_logs_play 
ADD INDEX IF NOT EXISTS idx_account_status (account_id, status);

-- Index for logs_play task_id
ALTER TABLE c19_logs_play 
ADD INDEX IF NOT EXISTS idx_task_id (task_id);

-- Index for account queries (is_done)
-- Used in: getCountPointForType() - WHERE is_done
ALTER TABLE c19_account 
ADD INDEX IF NOT EXISTS idx_is_done (is_done);

-- Composite index for account (is_done, schools_id)
-- Used when filtering by school
ALTER TABLE c19_account 
ADD INDEX IF NOT EXISTS idx_is_done_school (is_done, schools_id);

-- Index for account id (if not already primary key)
-- Used in: JOIN queries
ALTER TABLE c19_account 
ADD INDEX IF NOT EXISTS idx_id (id);

-- Show indexes after creation
SHOW INDEX FROM c19_logs_point;
SHOW INDEX FROM c19_logs_play;
SHOW INDEX FROM c19_account;
