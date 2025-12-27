<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/babel">
    const App = () => {
        const [formSearch] = Form.useForm();
        const [form] = Form.useForm();
        const [codes, setCodes] = useState({pagination: null, dataSource: []});
        const [isLoading, setLoading] = useState(false);
        const [acLoad, setAcLoad] = useState(false);
        const [visible, setVisible] = useState(false);


        const onRemove = async (id) => {
            await API_V2.ACTIVE_CODE.DELETE(id);
            await onGetList();
        }
        const onToggle = async () => {
            setVisible(!visible);
            form.resetFields();
            await onGetList();
        }
        const autoGenerateCode = () => {
            const prefix = "DQ-";
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            const randomCode = prefix + Array.from({length: 6}, () => characters[Math.floor(Math.random() * characters.length)]).join('');
            form.setFieldValue('code', randomCode)
        }
        const onFinish = async (formData) => {
            setAcLoad(true);
            await API_V2.ACTIVE_CODE.CREATE(formData).then(onToggle);
            setAcLoad(false);
        }
        const onGetList = async (params= {}) => {
            try {
                setLoading(true);
                const response = await API_V2.ACTIVE_CODE.GET(params);
                // console.log('response', response)
                setCodes(response)
            } catch (e) {
                message.error(e.message)
            } finally {
                setLoading(false);
            }
        }

        useEffect(() => {
            onGetList();
        }, []);

        return <section className="content">
            <Card title='Mã thanh toán' extra={<Space>
                <Button onClick={onToggle}>Thêm mới</Button>
            </Space>}>
                <Spin spinning={isLoading}>
                    <Table
                        {...codes}
                        onChange={({current, pageSize}) => onGetList({page: current, pageSize})}
                        columns={[
                            {title: 'Mã thanh toán', dataIndex: 'code', key: 'code'},
                            {title: 'Ngày tạo', dataIndex: 'created_at', key: 'created_at', render: toDate},
                            {
                                title: 'Trạng thái',
                                dataIndex: 'is_active',
                                key: 'is_active',
                                render: (active, raw) => {
                                    const isUsed = active == 1;
                                    return <Badge status={isUsed ? 'success' : 'error'}
                                                  text={isUsed ? 'Đã sử dụng' : 'Chưa áp dụng'}/>
                                }
                            },
                            {
                                title: 'Tài khoản kích hoạt',
                                dataIndex: 'active_for',
                                key: 'active_for',
                                render: (active_for, raw) => {
                                    if (!raw.account) {
                                        return '---'
                                    }
                                    return raw.account.email
                                }
                            },
                            {title: 'Ngày kích hoạt', dataIndex: 'active_at', key: 'active_at', render: toDate},
                            {
                                title: 'Hành động', key: 'action', render: (raw) => {
                                    return <Space>
                                        <Popconfirm onConfirm={() => onRemove(raw.id)}
                                                    title={`Chú ý! bạn đang chọn xóa mã kích hoạt ${raw.code}`}>
                                            <Button danger size="small">Xóa</Button>
                                        </Popconfirm>
                                    </Space>
                                }
                            },
                        ]}
                    />
                </Spin>

            </Card>
            <Modal
                open={visible}
                onCancel={onToggle}
                footer={[<Button loading={acLoad} htmlType="submit" form="crudForm">Lưu</Button>,
                    <Button onClick={onToggle}>Hủy</Button>]}
                title="Thêm mã kích hoạt">
                <Form id="crudForm" onFinish={onFinish}
                      labelCol={{sm: 8}}
                      labelAlign={`left`} form={form}>
                    <Form.Item hidden name="id">
                        <Input/>
                    </Form.Item>
                    <Form.Item label="Mã code">
                        <Space>
                            <Form.Item name="code" noStyle>
                                <Input placeholder="DQABCHAD"/>
                            </Form.Item>
                            <Button onClick={autoGenerateCode}>Tạo</Button>
                        </Space>
                    </Form.Item>
                </Form>
            </Modal>
        </section>
    }
    ReactDOM.render(<App/>, document.getElementById('app'));
</script>
