export class PushNotification {
    priority: number;
    registration_ids: string[] = [];
    notification: NotificationContent
}

export class NotificationContent {
    title: string;
    body: string;
    icon: string;
    click_action: string;
}