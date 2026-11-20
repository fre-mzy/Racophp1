
CREATE TABLE IF NOT EXISTS admin_users (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,

    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    role VARCHAR(50) NOT NULL DEFAULT 'read_only',

    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    last_login_at TIMESTAMPTZ NULL,

    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT admin_users_valid_role
    CHECK (
        role IN (
            'super_admin',
            'executive_supervisor',
            'finance_admin',
            'programme_manager',
            'content_admin',
            'read_only'
        )
    )
);

CREATE INDEX IF NOT EXISTS idx_admin_users_active
ON admin_users (is_active);

CREATE INDEX IF NOT EXISTS idx_admin_users_role
ON admin_users (role);
