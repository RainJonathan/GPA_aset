CREATE TRIGGER `after_insert_tuan_rumah` AFTER INSERT ON `tuan_rumah`
 FOR EACH ROW BEGIN
    DECLARE asset_name VARCHAR(255);
    DECLARE asset_code VARCHAR(255);
    DECLARE asset_address VARCHAR(255);

    -- Fetch asset details from rekap_aset table
    SELECT nama_aset, kode_aset, alamat INTO asset_name, asset_code, asset_address
    FROM rekap_aset 
    WHERE id = NEW.asset_id;

    -- Insert into outbox table
    INSERT INTO outbox (wa_no, wa_text, send_status, created_by, created_at, updated_at)
    VALUES (
        NEW.no_tlp,
        CONCAT('Masa sewa anda akan berakhir pada ', NEW.tgl_akhir, ' di ', asset_name, ' - ', asset_address),
        'N',
        'ADMIN',
        CURRENT_TIMESTAMP,
        CURRENT_TIMESTAMP
    );
END